<?php

namespace MyBuilder\Cronos\Formatter;

/**
 * Cron file
 *
 * This class is responsible for building and outputing the Cron file
 */
class Cron
{
    /**
     * @var Header
     */
    private $header;
    /**
     * @var Line[]
     */
    private $lines = array();

    public function __construct()
    {
        $this->header = new Header($this);
    }

    /**
     * Begin configuring the header
     *
     * @return Header
     */
    public function beginHeader()
    {
        return $this->header;
    }

    /**
     * Add a new line to the cron
     *
     * @param string $command
     *
     * @return Line
     */
    public function newLine($command)
    {
        $line = new Line($command, $this);
        $this->lines[] = $line;

        return $line;
    }

    /**
     * @return int
     */
    public function countLines()
    {
        return count($this->lines);
    }

    /**
     * Convert this to a format suitable for cron
     *
     * @return string
     */
    public function format()
    {
        $lines = '';
        foreach ($this->lines as $line) {
            $lines .= $line->format() . PHP_EOL;
        }

        return $this->header->format() . $lines;
    }
}
