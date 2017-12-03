<?php

namespace Otus;

use Otus\Exceptions\EmptyContentException;


class FileSystem
{
    /**
     * Returns content by path
     *
     * @param string $path
     *
     * @return string
     *
     * @throws EmptyContentException
     */
    public function getContent(string $path): string
    {
        if (!file_exists($path)) {
            throw new EmptyContentException("File {$path} not found");
        }

        $content = file_get_contents($path);

        if (empty($content)) {
            throw new EmptyContentException('Content is empty');
        }

        return $content;
    }

    /**
     * @param string $filename
     *
     * @return bool|resource
     */
    public function getWriteDescriptor(string $filename)
    {
        return fopen($filename, 'wb');
    }

    public function closeDescriptor($handle)
    {
        return fclose($handle);
    }
}