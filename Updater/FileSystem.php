<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem as FileSystemHelper;

/**
 * Responsible for abstracting the file system functions
 */
class FileSystem
{
    /**
     * @var FileSystemHelper;
     */
    private $filesystem;


    /**
     * Create a Temp File with the given content and return the path to that file
     *
     * @param string $prefix
     * @param string $content
     *
     * @return string
     *
     * @throws IOException If the file cannot be written to.
     */
    public function createTempFile($prefix, $content)
    {
        $filePath = $this->createTempName($prefix);
        $this->filesystem->dumpFile($filePath, $content);

        return $filePath;
    }

    private function createTempName($prefix)
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

    /**
     * Remove file
     *
     * @param string $filePath
     *
     * @throws IOException When removal fails
     */
    public function removeFile($filePath)
    {
        $this->filesystem->remove($filePath);
    }
}
