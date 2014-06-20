<?php

namespace MyBuilder\Cronos\Formatter;

class Cron
{
    /**
     * @var Header
     */
    private $header;

    /**
     * @var mixed[]
     */
    private $lines = array();

    public function __construct()
    {
        $this->header = new Header($this);
    }

    /**
     * @return Header
     */
    public function header()
    {
        return $this->header;
    }

    /**
     * @param string $command
     *
     * @return Job
     */
    public function job($command)
    {
        $line = new Job($command, $this);
        $this->lines[] = $line;

        return $line;
    }

    /**
     * @param string $comment
     *
     * @return Cron
     */
    public function comment($comment)
    {
        $this->lines[] = new Comment($comment);

        return $this;
    }

    /**
     * @return int
     */
    public function countLines()
    {
        return count($this->lines);
    }

    /**
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
