<?php

namespace MyBuilder\Cronos\Updater;

class StandardFileSystem implements FileSystem
{
    public function createTempFile(string $prefix, string $content): string
    {
        $filePath = $this->createTempName($prefix);
        \file_put_contents($filePath, $content);

        return $filePath;
    }

    private function createTempName(string $prefix): string
    {
        return \tempnam(\sys_get_temp_dir(), $prefix);
    }

    public function removeFile(string $filePath): void
    {
        \unlink($filePath);
    }
}
