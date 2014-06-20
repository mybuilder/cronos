<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Formatter\Time;

class TimeTest extends \PHPUnit_Framework_TestCase
{
    private $time;

    protected function setUp()
    {
        $this->time = new Time;
    }

    /**
     * @test
     */
    public function defaultShouldGenerateWildcards()
    {
        $this->assertEquals('*    *    *    *    *    ', $this->time->format());
    }

    /**
     * @test
     */
    public function setMinuteShouldConfigureMinute()
    {
        $this->time->setMinute(1);
        $this->assertEquals('1    *    *    *    *    ', $this->time->format());
    }

    /**
     * @test
     */
    public function setHourShouldConfigureHour()
    {
        $this->time->setHour(2);
        $this->assertEquals('*    2    *    *    *    ', $this->time->format());
    }

    /**
     * @test
     */
    public function setDayOfMonthShouldConfigureDayOfMonth()
    {
        $this->time->setDayOfMonth(3);
        $this->assertEquals('*    *    3    *    *    ', $this->time->format());
    }

    /**
     * @test
     */
    public function setMonthShouldConfigureMonth()
    {
        $this->time->setMonth(4);
        $this->assertEquals('*    *    *    4    *    ', $this->time->format());
    }

    /**
     * @test
     */
    public function setDayOfWeekShouldConfigureMonth()
    {
        $this->time->setDayOfWeek(5);
        $this->assertEquals('*    *    *    *    5    ', $this->time->format());
    }
}
