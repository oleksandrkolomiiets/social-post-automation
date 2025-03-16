<?php

namespace App\Console\Commands;

use App\Services\PostTemplateImportService;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;

class ImportPostTemplates extends Command
{
    protected $signature = 'app:import-post-templates';

    protected $description = 'Import post templates data to database';

    public function __construct(private readonly PostTemplateImportService $importService)
    {
        parent::__construct();
    }

    /**
     * @throws UnavailableStream
     * @throws InvalidArgument
     * @throws SyntaxError
     * @throws Exception
     * @throws ValidationException
     */
    public function handle(): void
    {
        $filePath = resource_path('data/posts.csv'); // A laravel command argument could be used for a dynamic file name

        $this->info("Importing post templates from: {$filePath}");

        $count = $this->importService->importFromCsvFile($filePath);

        $this->info("$count post templates imported successfully.");
    }
}
