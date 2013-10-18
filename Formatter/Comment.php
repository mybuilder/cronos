<?php

namespace MyBuilder\Cronos\Formatter;

/**
 * Formats the comment
 */
class Comment
{
    /**
     * @var string
     */
    private $comment;

    /**
     * Add a comment
     *
     * @param string $comment
     */
    public function addComment($comment)
    {
        $this->comment = $this->removeBreaks($comment);
    }

    /**
     * Remove line breaks
     *
     * @param string $text
     *
     * @return string
     */
    private function removeBreaks($text)
    {
        return str_replace(array("\r", "\r\n", "\n", PHP_EOL), '', $text);
    }

    /**
     * Format the given comment
     *
     * @return string
     */
    public function format()
    {
        return ($this->comment) ? PHP_EOL . '#' . $this->comment . PHP_EOL : '';
    }
}
