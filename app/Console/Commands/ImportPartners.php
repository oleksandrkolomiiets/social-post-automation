<?php

namespace App\Console\Commands;

use App\Services\PartnerImportService;
use Illuminate\Console\Command;

class ImportPartners extends Command
{
    protected $signature = 'app:import-partners';

    protected $description = 'Import partners data to database';

    public function __construct(private readonly PartnerImportService $importService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $filePath = resource_path('data/partners.csv'); // A laravel command argument could be used for a dynamic file name

        $this->info("Importing partners from: {$filePath}");

        $count = $this->importService->importFromCsvFile($filePath);

        $this->info("$count partners imported successfully.");
    }
}
