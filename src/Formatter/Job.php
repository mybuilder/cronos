<?php

namespace MyBuilder\Cronos\Formatter;

class Job
{
    /**
     * @var Cron
     */
    private $cron;

    /**
     * @var Time
     */
    private $time;

    /**
     * @var string
     */
    private $command;

    /**
     * @var Output
     */
    private $output;

    /**
     * @param string $command
     * @param Cron $cron
     */
    public function __construct($command, Cron $cron)
    {
        $this->cron = $cron;
        $this->time = new Time;
        $this->command = $command;
        $this->output = new Output;
    }

    /**
     * @param string $value
     *
     * @return $this
     *
     * @see Time::setMinute
     */
    public function setMinute($value)
    {
        $this->time->setMinute($value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     *
     * @see Time::setHour
     */
    public function setHour($value)
    {
        $this->time->setHour($value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     *
     * @see Time::setDayOfMonth
     */
    public function setDayOfMonth($value)
    {
        $this->time->setDayOfMonth($value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     *
     * @see Time::setMonth
     */
    public function setMonth($value)
    {
        $this->time->setMonth($value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     *
     * @see Time::setDayOfWeek
     */
    public function setDayOfWeek($value)
    {
        $this->time->setDayOfWeek($value);

        return $this;
    }

    /**
     * Suppress the output of this command when executed
     *
     * @return $this
     *
     * @see Output::suppressOutput
     */
    public function suppressOutput()
    {
        $this->output->suppressOutput();

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     *
     * @see Output::setStandardOutFile
     */
    public function setStandardOutFile($filePath)
    {
        $this->output->setStandardOutFile($filePath);

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     *
     * @see Output::setStandardErrorFile
     */
    public function setStandardErrorFile($filePath)
    {
        $this->output->setStandardErrorFile($filePath);

        return $this;
    }

    /**
     * @return Cron
     */
    public function end()
    {
        return $this->cron;
    }

    /**
     * @return string
     */
    public function format()
    {
        return
            $this->time->format() .
            $this->command .
            $this->output->format() .
            PHP_EOL;
    }
}
