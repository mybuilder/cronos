<?php

namespace MyBuilder\Cronos\Formatter;

use MyBuilder\Cronos\Updater\CronProcessUpdater;
use Mockery as m;

class CronProcessUpdaterTest extends \PHPUnit_Framework_TestCase
{
    const IRRELEVANT_FILENAME = 'X';

    private $processRunnerMock;
    private $fileSystemMock;
    /**
     * @var CronProcessUpdater
     */
    private $cronProcessUpdater;

    protected function setUp()
    {
        m::getConfiguration()->allowMockingNonExistentMethods(false);
        $this->processRunnerMock = m::mock('MyBuilder\Cronos\Updater\ProcessRunner');
        $this->fileSystemMock = m::mock('MyBuilder\Cronos\Updater\FileSystem');
        $this->cronProcessUpdater = new CronProcessUpdater($this->processRunnerMock, $this->fileSystemMock);
    }

    /**
     * @test
     */
    public function shouldUpdateCron()
    {
        $this->shouldCreateCronFile();
        $this->runningTheProcessShouldReturn(true);
        $this->updatesCron();
    }

    private function shouldCreateCronFile()
    {
        $this->tempFileShouldBeCreated();
        $this->fileShouldBeRemoved();
    }

    private function tempFileShouldBeCreated()
    {
        $this->fileSystemMock->shouldReceive('createTempFile')->with('cron', '')->andReturn(self::IRRELEVANT_FILENAME);
    }

    private function fileShouldBeRemoved()
    {
        $this->fileSystemMock->shouldReceive('removeFile')->with(self::IRRELEVANT_FILENAME);
    }

    private function runningTheProcessShouldReturn($value, $crontab = 'crontab')
    {
        $this->processRunnerMock->shouldReceive('run')->with($crontab . ' ' . self::IRRELEVANT_FILENAME)->andReturn($value);
    }

    private function updatesCron()
    {
        $this->cronProcessUpdater->updateWith(new Cron());
    }

    /**
     * @test
     * @expectedException MyBuilder\Cronos\Updater\CronUpdatingError
     */
    public function unsuccessfulProcessExecutionShouldRaiseException()
    {
        $this->shouldCreateCronFile();
        $this->runningTheProcessShouldReturn(false);
        $this->updatesCron();
    }

    /**
     * @test
     */
    public function shouldSetupCustomCrontabCommand()
    {
        $this->shouldCreateCronFile();
        $this->cronProcessUpdater->setCrontabCommand('/usr/local/crontab');
        $this->runningTheProcessShouldReturn(true, '/usr/local/crontab');
        $this->updatesCron();
    }
}
