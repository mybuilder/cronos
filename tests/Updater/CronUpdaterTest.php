<?php

namespace MyBuilder\Cronos\Tests\Updater;

use MyBuilder\Cronos\Formatter\Cron;
use MyBuilder\Cronos\Updater\CronManipulator;
use MyBuilder\Cronos\Updater\CronUpdater;
use PHPUnit\Framework\TestCase;

class CronUpdaterTest extends TestCase
{
    private CronManipulatorStub $manipulatorStub;
    private CronUpdater $updater;

    protected function setUp(): void
    {
        $this->manipulatorStub = new CronManipulatorStub();

        $this->updater = new CronUpdater($this->manipulatorStub);
    }

    /**
     * @test
     */
    public function shouldReplaceContent(): void
    {
        $this->updater->replaceWith(new Cron());

        $this->assertEquals(\PHP_EOL, $this->manipulatorStub->contents);
    }

    /**
     * @test
     */
    public function shouldAppendKeyIfNotExist(): void
    {
        $this->manipulatorStub->contents = <<<CRON
headers
# KEY key1
value 1
# END
no key
CRON;

        $cron = new Cron();
        $cron->header()->setPath('path')->end();
        $cron->comment('new content');
        $this->updater->updateWith($cron, 'key2');

        $expectedCron = <<<CRON
headers
# KEY key1
value 1
# END
no key
# KEY key2
PATH=path

#new content
# END

CRON;

        $this->assertEquals($expectedCron, $this->manipulatorStub->contents);
    }

    /**
     * @test
     */
    public function shouldReplaceKeyIfExist(): void
    {
        $this->manipulatorStub->contents = <<<CRON
headers
# KEY key1
value 1
# END
no key
# KEY key2
# must be replaced
# END
# KEY key3
foo
# END

CRON;

        $cron = new Cron();
        $cron->comment('replace');
        $this->updater->updateWith($cron, 'key2');

        $expectedCron = <<<CRON
headers
# KEY key1
value 1
# END
no key
# KEY key2
#replace
# END
# KEY key3
foo
# END

CRON;

        $this->assertEquals($expectedCron, $this->manipulatorStub->contents);
    }
}

class CronManipulatorStub implements CronManipulator
{
    public string $contents;

    public function replace(string $contents): void
    {
        $this->contents = $contents;
    }

    public function getContent(): string
    {
        return $this->contents;
    }
}
