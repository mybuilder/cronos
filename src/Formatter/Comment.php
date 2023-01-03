<?php

namespace MyBuilder\Cronos\Formatter;

class Comment
{
    public function __construct(private string $comment)
    {}

    public function format(): string
    {
        return '#' . $this->removeLineBreaks($this->comment);
    }

    private function removeLineBreaks($text): string
    {
        return \str_replace(["\r", "\r\n", "\n", \PHP_EOL], '', $text);
    }
}
