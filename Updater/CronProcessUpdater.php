<?php

namespace MyBuilder\Cronos\Updater;

class CronProcessUpdater
{
    const CRONTAB_COMMAND = 'crontab';
    const TEMP_FILE_PREFIX = 'cron';

    /**
     * @var ProcessRunner
     */
    private $processRunner;
    /**
     * @var FileSystem
     */
    private $fileSystem;
    /**
     * @var string
     */
    private $crontabCommand = self::CRONTAB_COMMAND;

    public function __construct($processRunner, $fileSystem)
    {
        $this->processRunner = $processRunner;
        $this->fileSystem = $fileSystem;
    }

    public function updateWith($cron)
    {
        $filePath = $this->fileSystem->createTempFile(self::TEMP_FILE_PREFIX, $cron->format());
        $isWritten = $this->processRunner->run($this->crontabCommand . ' ' . $filePath);
        $this->fileSystem->removeFile($filePath);
        if (!$isWritten) {
            throw new CronUpdatingError;
        }
    }

    /**
     * Set the crontab command
     *
     * If your crontab executable is in not in your path you can use this to specify it
     *
     * @param string $crontabCommand
     */
    public function setCrontabCommand($crontabCommand)
    {
        $this->crontabCommand = $crontabCommand;
    }
}
