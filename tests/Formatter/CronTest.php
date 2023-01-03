<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Formatter\Cron;
use PHPUnit\Framework\TestCase;

class CronTest extends TestCase
{
    private Cron $cron;

    protected function setUp(): void
    {
        $this->cron = new Cron;
    }

    /**
     * @test
     */
    public function shouldBuildConfiguration(): void
    {
        $this->cron
            ->header()
                ->setPath('path')
                ->setHome('home')
                ->setMailto('test@example.com')
                ->setShell('shell')
                ->setContentType('text')
                ->setContentTransferEncoding('utf8')
                ->setTimezone('Europe/Paris')
            ->end()
            ->comment('This is a command!')
            ->job('/bin/bash command --env=dev')
                ->setMinute(1)
                ->setHour(2)
                ->setDayOfMonth(3)
                ->setMonth(4)
                ->setDayOfWeek(5)
                ->setStandardOutFile('log')
                ->appendStandardErrorToFile('error')
            ->end()
            ->comment('This is another command!')
            ->job('/bin/php command2 --env=prod')
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
CRON_TZ=Europe/Paris

#This is a command!
1    2    3    4    5    /bin/bash command --env=dev > log 2>> error

#This is another command!
*/5  *    *    *    sun  /bin/php command2 --env=prod > /dev/null 2> /dev/null

EXP;

        $this->assertEquals($expected, $this->cron->format());
    }
}
