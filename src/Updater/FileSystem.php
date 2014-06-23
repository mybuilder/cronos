<?php

namespace MyBuilder\Cronos\Updater;

interface FileSystem
{
    /**
     * @param string $prefix
     * @param string $content
     *
     * @return string
     */
    public function createTempFile($prefix, $content);

    /**
     * @param string $filePath
     */
    public function removeFile($filePath);
}
