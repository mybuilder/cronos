<?php

namespace MyBuilder\Cronos\Formatter;

/**
 * Rather than using  * /5  for 5 minutes you can simply use /5
 *
 *
 *     field          allowed values
 *     -----          --------------
 *     minute         0-59
 *     hour           0-23
 *     day of month   1-31
 *     month          1-12 (or names, see below)
 *     day of week    0-7 (0 or 7 is Sun, or use names)
 *
 * Ranges of numbers are allowed.  Ranges are two numbers separated with a
 * hyphen.  The specified range is inclusive.  For example,  8-11  for  an
 * ``hours'' entry specifies execution at hours 8, 9, 10 and 11.
 *
 * Lists are allowed.  A list is a set of numbers (or ranges) separated by
 * commas.  Examples: ``1,2,5,9'', ``0-4,8-12''.
 */
class Time
{
    const FORMAT = '%-4s %-4s %-4s %-4s %-4s ';
    const WILDCARD_TIME = '*';

    /**
     * @var string
     */
    private $minute = self::WILDCARD_TIME;

    /**
     * @var string
     */
    private $hour = self::WILDCARD_TIME;

    /**
     * @var string
     */
    private $dayOfMonth = self::WILDCARD_TIME;

    /**
     * @var string
     */
    private $month = self::WILDCARD_TIME;

    /**
     * @var string
     */
    private $dayOfWeek = self::WILDCARD_TIME;

    /**
     * @param string $value 0-59 or a list or range
     *
     * @return $this
     */
    public function setMinute($value)
    {
        $this->minute = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-23 or a list or range
     *
     * @return $this
     */
    public function setHour($value)
    {
        $this->hour = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-31 or a list or range
     *
     * @return $this
     */
    public function setDayOfMonth($value)
    {
        $this->dayOfMonth = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-12 or a list or range
     *
     * @return $this
     */
    public function setMonth($value)
    {
        $this->month = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-7 (0 or 7 is Sun, or use names) or a list or range
     *
     * @return $this
     */
    public function setDayOfWeek($value)
    {
        $this->dayOfWeek = $this->parse($value);

        return $this;
    }

    /**
     * @return string
     */
    public function format()
    {
        return sprintf(self::FORMAT, $this->minute, $this->hour, $this->dayOfMonth, $this->month, $this->dayOfWeek);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function parse($value)
    {
        if ('/' === $value[0]) {
            return self::WILDCARD_TIME . $value;
        }

        return $value;
    }
}
