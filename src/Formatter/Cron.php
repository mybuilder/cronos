<?php

namespace MyBuilder\Cronos\Formatter;

class Cron
{
    private ?Header $header = null;

    /** @var mixed[] */
    private array $lines = [];

    public function header(): Header
    {
        $this->header = new Header($this);

        return $this->header;
    }

    public function job(string $command): Job
    {
        $line = new Job($command, $this);
        $this->lines[] = $line;

        return $line;
    }

    public function comment(string $comment): Cron
    {
        $this->lines[] = new Comment($comment);

        return $this;
    }

    public function countLines(): int
    {
        return count($this->lines);
    }

    public function format(): string
    {
        $lines = '';

        foreach ($this->lines as $line) {
            $lines .= $line->format() . \PHP_EOL;
        }

        return (($this->hasHeader()) ? $this->header->format() . \PHP_EOL : '') . \trim($lines) . \PHP_EOL;
    }

    public function hasHeader(): bool
    {
        return $this->header !== null;
    }
}
