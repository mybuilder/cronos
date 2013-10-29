<?php

namespace MyBuilder\Cronos\Updater;

/**
 * Responsible for abstracting the file system functions
 */
interface FileSystem
{
    /**
     * Create a Temp File with the given content and return the path to that file
     *
     * @param string $prefix
     * @param string $content
     *
     * @return string
     */
    public function createTempFile($prefix, $content);

    /**
     * Remove file
     *
     * @param string $filePath
     */
    public function removeFile($filePath);
}
