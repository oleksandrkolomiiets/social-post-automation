<?php

namespace App\Services;

use App\Events\PostTemplateCreated;
use App\Models\PostTemplate;
use App\Services\Validators\PostTemplateImportValidator;
use Illuminate\Validation\ValidationException;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;

class PostTemplateImportService
{
    public function __construct(protected FileService $fileService, protected PostTemplateImportValidator $validator)
    {
        //
    }

    /**
     * @throws InvalidArgument
     * @throws UnavailableStream
     * @throws SyntaxError
     * @throws Exception
     * @throws ValidationException
     */
    public function importFromCsvFile(string $filePath): int
    {
        $data = $this->fileService->parseCsv($filePath);

        if (empty($data)) {
            return 0;
        }

        $records = $this->validator->validated($data);

        foreach ($records as $record) {
            $partner = PostTemplate::query()->create($record);

            event(new PostTemplateCreated($partner));
        }

        return count($records);
    }
}
