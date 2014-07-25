<?php

namespace MyBuilder\Cronos\Updater;

class StandardFileSystem implements FileSystem
{
    /**
     * {@inheritdoc}
     */
    public function createTempFile($prefix, $content)
    {
        $filePath = $this->createTempName($prefix);
        file_put_contents($filePath, $content);

        return $filePath;
    }

    private function createTempName($prefix)
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }

    /**
     * {@inheritdoc}
     */
    public function removeFile($filePath)
    {
        unlink($filePath);
    }
}
