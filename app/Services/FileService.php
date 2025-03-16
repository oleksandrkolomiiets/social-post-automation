<?php

namespace App\Services;

use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;

class FileService
{
    /**
     * @throws UnavailableStream
     * @throws InvalidArgument
     * @throws SyntaxError
     * @throws Exception
     */
    public function parseCsv(string $path): array
    {
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $stmt = new Statement();

        return iterator_to_array($stmt->process($csv));
    }
}
