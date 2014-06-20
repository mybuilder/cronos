<?php

namespace MyBuilder\Cronos\Formatter;

class Comment
{
    /**
     * @var string
     */
    private $comment;

    /**
     * @param string $comment
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function format()
    {
        return PHP_EOL . '#' . $this->removeLineBreaks($this->comment);
    }

    private function removeLineBreaks($text)
    {
        return str_replace(array("\r", "\r\n", "\n", PHP_EOL), '', $text);
    }
}
