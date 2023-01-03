<?php

namespace MyBuilder\Cronos\Formatter;

class Job
{
    private Time $time;
    private Output $output;

    public function __construct(private string $command, private Cron $cron)
    {
        $this->time = new Time;
        $this->output = new Output;
    }

     /** @see Time::setMinute */
    public function setMinute(string $value): self
    {
        $this->time->setMinute($value);

        return $this;
    }

    /** @see Time::setHour */
    public function setHour(string $value): self
    {
        $this->time->setHour($value);

        return $this;
    }

    /** @see Time::setDayOfMonth */
    public function setDayOfMonth(string $value): self
    {
        $this->time->setDayOfMonth($value);

        return $this;
    }

    /** @see Time::setMonth */
    public function setMonth(string $value): self
    {
        $this->time->setMonth($value);

        return $this;
    }

    /** @see Time::setDayOfWeek */
    public function setDayOfWeek(string$value): self
    {
        $this->time->setDayOfWeek($value);

        return $this;
    }

    /**
     * Suppress the output of this command when executed
     *
     * @see Output::suppressOutput
     */
    public function suppressOutput(): self
    {
        $this->output->suppressOutput();

        return $this;
    }

    /** @see Output::setStandardOutFile */
    public function setStandardOutFile(string $filePath): self
    {
        $this->output->setStandardOutFile($filePath);

        return $this;
    }

    /** @see Output::appendStandardOutToFile */
    public function appendStandardOutToFile(string $filePath): self
    {
        $this->output->appendStandardOutToFile($filePath);

        return $this;
    }

    /** @see Output::setStandardErrorFile */
    public function setStandardErrorFile(string $filePath): self
    {
        $this->output->setStandardErrorFile($filePath);

        return $this;
    }

    /** @see Output::appendStandardErrorToFile */
    public function appendStandardErrorToFile(string $filePath): self
    {
        $this->output->appendStandardErrorToFile($filePath);

        return $this;
    }

    public function end(): Cron
    {
        return $this->cron;
    }

    public function format(): string
    {
        return
            $this->time->format() .
            $this->command .
            $this->output->format() .
            \PHP_EOL;
    }
}
