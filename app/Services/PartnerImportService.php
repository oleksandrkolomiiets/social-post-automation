<?php

namespace App\Services;

use App\Events\PartnerCreated;
use App\Models\Partner;
use App\Services\Validators\PartnerImportValidator;
use Illuminate\Validation\ValidationException;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;

class PartnerImportService
{
    public function __construct(protected FileService $fileService, protected PartnerImportValidator $validator)
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
            $partner = Partner::query()->create($record);

            event(new PartnerCreated($partner));
        }

        return count($records);
    }
}
