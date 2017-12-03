<?php

namespace Otus;

use Otus\Exceptions\EmptyContentException;


class CsvParser
{
    /**
     * @var FileSystem
     */
    private $fileSystem;

    /**
     * CsvParser constructor.
     *
     * @param FileSystem $fileSystem
     */
    public function __construct(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * Returns CSV file as array
     *
     * @param string $path
     *
     * @return array
     *
     * @throws EmptyContentException
     */
    public function getLines(string $path): array
    {
        $csv = $this->fileSystem->getContent($path);
        $lines = explode(PHP_EOL, $csv);

        $result = [];
        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $result[] = str_getcsv($line);
        }

        return $result;
    }

    /**
     * Stores arrays as CSV file
     *
     * @param string $path
     * @param array $lines
     */
    public function storeLines(string $path, array $lines)
    {
        $file = $this->fileSystem->getWriteDescriptor($path);

        foreach ($lines as $line) {
            fputcsv($file, $line);
        }

        $this->fileSystem->closeDescriptor($file);
    }
}