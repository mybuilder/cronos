<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Formatter\Cron;

class CronTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cron
     */
    private $cron;

    protected function setUp()
    {
        $this->cron = new Cron;
    }

    /**
     * @test
     */
    public function shouldBuildConfiguration()
    {
        $this->cron
            ->beginHeader()
                ->setPath('path')
                ->setHome('home')
                ->setMailto('test@example.com')
                ->setShell('shell')
                ->setContentType('text')
                ->setContentTransferEncoding('utf8')
            ->end()
            ->newLine('/bin/bash command --env=dev')
                ->addComment('This is a command!')
                ->setMinute(1)
                ->setHour(2)
                ->setDayOfMonth(3)
                ->setMonth(4)
                ->setDayOfWeek(5)
                ->setStandardOutFile('log')
                ->setStandardErrorFile('error')
            ->end()
            ->newLine('/bin/php command2 --env=prod')
                ->addComment('This is another command!')
                ->setMinute('/5')
                ->setDayOfWeek('sun')
                ->suppressOutput()
            ->end();

        $expected = <<<EXP
PATH=path
MAILTO=test@example.com
HOME=home
SHELL=shell
CONTENT_TYPE=text
CONTENT_TRANSFER_ENCODING=utf8

#This is a command!
1    2    3    4    5    /bin/bash command --env=dev > log 2> error

#This is another command!
*/5  *    *    *    sun  /bin/php command2 --env=prod > /dev/null 2> /dev/null

EXP;
        
        $this->assertEquals($expected, $this->cron->format());
    }
}
