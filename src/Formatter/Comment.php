<?php

namespace MyBuilder\Cronos\Formatter;

class Comment
{
    /** @var string */
    private $comment;

    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    public function format(): string
    {
        return '#' . $this->removeLineBreaks($this->comment);
    }

    private function removeLineBreaks($text): string
    {
        return \str_replace(["\r", "\r\n", "\n", \PHP_EOL], '', $text);
    }
}
