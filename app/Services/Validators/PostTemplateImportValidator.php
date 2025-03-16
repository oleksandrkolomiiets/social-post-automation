<?php

namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PostTemplateImportValidator
{
    /**
     * @throws ValidationException
     */
    public function validated(array $data): array
    {
        $rules = [
            '*.title' => 'required|string|max:255',
            '*.headline' => 'required|string|max:255',
            '*.message' => 'required|string|max:255',
            '*.link' => 'required|string|max:255',
        ];

        $validator = Validator::make($data, $rules);

        return $validator->validated();
    }
}
