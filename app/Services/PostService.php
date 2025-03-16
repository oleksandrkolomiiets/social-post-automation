<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\PostTemplate;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PostService
{
    public function __construct(protected PostRepositoryInterface $repository)
    {
        //
    }

    public function generateForPartner(Partner $partner): void
    {
        PostTemplate::query()
            ->whereNotIn('id', function ($query) use ($partner) {
                $query->select('post_template_id')
                    ->from('posts')
                    ->where('partner_id', $partner->id);
            })
            ->chunk(500, function (Collection $templates) use ($partner) {
                $posts = [];

                foreach ($templates as $template) {
                    $postData = $this->getMappedPostData($template, $partner);

                    if ($postData === false) {
                        continue;
                    }

                    $posts[] = $postData;
                }

                $this->repository->createMany($posts);
            });
    }

    public function generateForPostTemplate(PostTemplate $postTemplate): void
    {
        Partner::query()
            ->whereNotIn('id', function ($query) use ($postTemplate) {
                $query->select('partner_id')
                    ->from('posts')
                    ->where('post_template_id', $postTemplate->id);
            })
            ->chunk(500, function (Collection $partners) use ($postTemplate) {
                $posts = [];

                foreach ($partners as $partner) {
                    $postData = $this->getMappedPostData($postTemplate, $partner);

                    if ($postData === false) {
                        continue;
                    }

                    $posts[] = $postData;
                }

                $this->repository->createMany($posts);
            });
    }

    private function getMappedPostData(PostTemplate $postTemplate, Partner $partner): array|false
    {
        $placeholders = $this->getAllPlaceholders($postTemplate);
        $values = $this->getAvailablePlaceholderValues($partner);

        $missing = [];

        foreach ($placeholders as $placeholder) {
            if (!array_key_exists($placeholder, $values) || empty($values[$placeholder])) {
                $missing[] = $placeholder;
            }
        }

        if (!empty($missing)) {
            $message = "Skipping template #{$postTemplate->id} for partner #{$partner->id}. Missing/invalid placeholders: " . implode(', ', $missing);

            // TODO Use $message to log the process (save in DB/logs)

            return false; // Skip when Missing/invalid placeholders are detected
        }

        $postData = [
            'uuid' => Str::uuid(),
            'post_template_id' => $postTemplate->id,
            'partner_id' => $partner->id,
        ];

        $fields = $this->getTemplateFields();

        foreach ($fields as $field) {
            $original = $postTemplate->{$field} ?? '';

            $postData[$field] = str_replace(
                array_keys($values),
                array_values($values),
                $original
            );
        }

        return $postData;
    }

    private function getAllPlaceholders(PostTemplate $postTemplate): array
    {
        $fields = $this->getTemplateFields();
        $placeholders = [];

        foreach ($fields as $field) {
            $text = $postTemplate->$field ?? '';

            preg_match_all('/\{\{[^}]+\}\}/', $text, $matches); // it returns ["{{name}}", "{{phone}}"]

            if (!empty($matches[0])) {
                $placeholders = array_merge($placeholders, $matches[0]);
            }
        }

        return array_unique($placeholders);
    }

    private function getTemplateFields(): array
    {
        return ['title', 'headline', 'message', 'link'];
    }

    private function getAvailablePlaceholderValues(Partner $partner): array
    {
        return [
            '{{name}}' => $partner->name,
            '{{phone}}' => $partner->phone,
            '{{website}}' => $partner->website,
            '{{country}}' => $partner->country,
        ];
    }
}
