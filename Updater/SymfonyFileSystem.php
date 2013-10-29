<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem as FileSystemHelper;

/**
 * Responsible for abstracting the file system functions
 */
class SymfonyFileSystem implements FileSystem
{
    /**
     * @var FileSystemHelper;
     */
    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new FileSystemHelper();
    }

    /**
     * {@inheritdoc}
     *
     * @throws IOException If the file cannot be written to.
     */
    public function createTempFile($prefix, $content)
    {
        $filePath = $this->createTempName($prefix);
        $this->dumpToFile($filePath, $content);

        return $filePath;
    }

    private function dumpToFile($filePath, $content)
    {
        if (method_exists($this->filesystem, 'dumpFile')) {
            $this->filesystem->dumpFile($filePath, $content);
        } else {
            file_put_contents($filePath, $content);
        }
    }

    private function createTempName($prefix)
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

    /**
     * {@inheritdoc}
     *
     * @throws IOException When removal fails
     */
    public function removeFile($filePath)
    {
        $this->filesystem->remove($filePath);
    }
}
