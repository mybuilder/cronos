<?php

namespace MyBuilder\Cronos\Updater;

class CommandCronManipulator implements CronManipulator
{
    /** @var ProcessRunner */
    private $processRunner;

    /** @var FileSystem */
    private $fileSystem;

    /** @var string */
    private $cronCommand;

    public function __construct(ProcessRunner $processRunner, FileSystem $fileSystem, string $cronCommand = 'crontab')
    {
        $this->processRunner = $processRunner;
        $this->fileSystem = $fileSystem;
        $this->cronCommand = $cronCommand;
    }

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
