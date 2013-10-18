<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Formatter\Comment;

class CommentTest extends \PHPUnit_Framework_TestCase
{
    private $comment;

    protected function setUp()
    {
        $this->comment = new Comment;
    }

    /**
     * @test
     */
    public function shouldGenerateCommentBlock()
    {
        $this->comment->addComment('comment');

        $expected = <<<EXP

#comment

EXP;

        $this->assertEquals($expected, $this->comment->format());
    }
}
