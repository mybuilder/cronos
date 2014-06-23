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

        $this->assertEquals('', $this->manipulatorStub->contents);
    }

    /**
     * @test
     */
    public function shouldAppendKeyIfNotExist()
    {
        $cron = new Cron;
        $cron->comment('new content');

        $this->manipulatorStub->contents = <<<CRON
headers
# KEY key1
value 1
# END
no key
CRON;

        $this->updater->updateWith($cron, 'key2');

        $expectedCron = <<<CRON
headers
# KEY key1
value 1
# END
no key
# KEY key2
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
        $cron = new Cron;
        $cron->comment('replace');

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