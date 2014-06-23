<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Process\Process;

class CommandCronManipulator implements CronManipulator
{
    private $processRunner;
    private $fileSystem;
    private $cronCommand;

    public function __construct(ProcessRunner $processRunner, FileSystem $fileSystem, $cronCommand = 'crontab')
    {
        $this->processRunner = $processRunner;
        $this->fileSystem = $fileSystem;
        $this->cronCommand = $cronCommand;
    }

    public function replace($contents)
    {
        $filePath = $this->fileSystem->createTempFile('cron', $contents);
        $this->processRunner->run($this->cronCommand . ' ' . $filePath);
        $this->fileSystem->removeFile($filePath);
    }

    public function getContent()
    {
        return $this->processRunner->run($this->cronCommand . ' -l');
    }
}