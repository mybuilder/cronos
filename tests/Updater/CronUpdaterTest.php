<?php

namespace MyBuilder\Cronos\Updater;

use Mockery as m;
use MyBuilder\Cronos\Formatter\Cron;

class CronUpdaterTest extends \PHPUnit_Framework_TestCase
{
    private $manipulatorStub;
    private $updater;

    public function setUp()
    {
        $this->manipulatorStub = new CronManipulatorStub;

        $this->updater = new CronUpdater($this->manipulatorStub);
    }

    /**
     * @test
     */
    public function shouldReplaceContent()
    {
        $this->updater->replaceWith(new Cron);

        $this->assertEquals("\n", $this->manipulatorStub->contents);
    }

    /**
     * @test
     */
    public function shouldAppendKeyIfNotExist()
    {
        $this->manipulatorStub->contents = <<<CRON
headers
# KEY key1
value 1
# END
no key
CRON;

        $cron = new Cron;
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
    public function shouldReplaceKeyIfExist()
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

        $cron = new Cron;
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
    public $contents;

    public function replace($contents)
    {
        $this->contents = $contents;
    }

    public function getContent()
    {
        return $this->contents;
    }
}