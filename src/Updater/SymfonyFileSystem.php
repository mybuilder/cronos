<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Filesystem\Filesystem as FileSystemHelper;

class SymfonyFileSystem implements FileSystem
{
    private FileSystemHelper $filesystem;

    public function __construct()
    {
        $this->filesystem = new FileSystemHelper();
    }

    /** @throws \Symfony\Component\Filesystem\Exception\IOException If the file cannot be written to. */
    public function createTempFile($prefix, $content): string
    {
        $filePath = $this->createTempName($prefix);
        $this->dumpToFile($filePath, $content);

        return $filePath;
    }

    private function dumpToFile(string $filePath, string $content): void
    {
        if (\method_exists($this->filesystem, 'dumpFile')) {
            $this->filesystem->dumpFile($filePath, $content);
        } else {
            \file_put_contents($filePath, $content);
        }
    }

    private function createTempName(string $prefix): string
    {
        return \tempnam(\sys_get_temp_dir(), $prefix);
    }

    /** @throws \Symfony\Component\Filesystem\Exception\IOException When removal fails */
    public function removeFile(string $filePath): void
    {
        $this->filesystem->remove($filePath);
    }
}
