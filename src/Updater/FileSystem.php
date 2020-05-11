<?php

namespace MyBuilder\Cronos\Updater;

interface FileSystem
{
    public function createTempFile(string $prefix, string $content): string;

    public function removeFile(string $filePath): void;
}
