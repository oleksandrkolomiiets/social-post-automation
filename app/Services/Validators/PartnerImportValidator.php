<?php

namespace App\Services\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PartnerImportValidator
{
    /**
     * @throws ValidationException
     */
    public function validated(array $data): array
    {
        $rules = [
            '*.id' => 'required|integer',
            '*.name' => 'required|max:255|unique:partners,name',
            '*.website' => 'nullable|max:255', // Could be a DNS record url check
            '*.phone' => 'nullable|max:255', // Could be a phone mask
            '*.country' => 'nullable|max:255', // Could be a country name validation rule
        ];

        $validator = Validator::make($data, $rules);

        return $validator->validated();
    }
}
