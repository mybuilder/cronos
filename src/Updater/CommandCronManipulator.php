<?php

namespace MyBuilder\Cronos\Updater;

class CommandCronManipulator implements CronManipulator
{
    public function __construct(private ProcessRunner $processRunner,
                                private FileSystem    $fileSystem,
                                private string        $cronCommand = 'crontab')
    {}

    public function replace(string $contents): void
    {
        $filePath = $this->fileSystem->createTempFile('cron', $contents);
        $this->processRunner->run([$this->cronCommand, $filePath]);
        $this->fileSystem->removeFile($filePath);
    }

    public function getContent(): string
    {
        return $this->processRunner->run([$this->cronCommand, '-l']);
    }
}
