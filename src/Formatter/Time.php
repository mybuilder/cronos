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
    public const FORMAT = '%-4s %-4s %-4s %-4s %-4s ';
    public const WILDCARD_TIME = '*';

    private string $minute = self::WILDCARD_TIME;
    private string $hour = self::WILDCARD_TIME;
    private string $dayOfMonth = self::WILDCARD_TIME;
    private string $month = self::WILDCARD_TIME;
    private string $dayOfWeek = self::WILDCARD_TIME;

    /**
     * @param string $value 0-59 or a list or range
     */
    public function setMinute(string $value): self
    {
        $this->minute = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-23 or a list or range
     */
    public function setHour(string $value): self
    {
        $this->hour = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-31 or a list or range
     */
    public function setDayOfMonth(string $value): self
    {
        $this->dayOfMonth = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-12 or a list or range
     */
    public function setMonth(string $value): self
    {
        $this->month = $this->parse($value);

        return $this;
    }

    /**
     * @param string $value 0-7 (0 or 7 is Sun, or use names) or a list or range
     */
    public function setDayOfWeek(string $value): self
    {
        $this->dayOfWeek = $this->parse($value);

        return $this;
    }

    public function format(): string
    {
        return \sprintf(self::FORMAT, $this->minute, $this->hour, $this->dayOfMonth, $this->month, $this->dayOfWeek);
    }

    private function parse(string $value): string
    {
        if (\str_starts_with($value, '/')) {
            return self::WILDCARD_TIME . $value;
        }

        return $value;
    }
}
