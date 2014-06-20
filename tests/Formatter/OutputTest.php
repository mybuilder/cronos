<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Formatter\Output;

class OutputTest extends \PHPUnit_Framework_TestCase
{
    private $output;

    protected function setUp()
    {
        $this->output = new Output;
    }

    /**
     * @test
     */
    public function suppressOutputShouldRedirectOutputToNothing()
    {
        $this->output->suppressOutput();
        $this->assertEquals(' > /dev/null 2> /dev/null', $this->output->format());
    }

    /**
     * @test
     */
    public function shouldSetTheStandardOutFile()
    {
        $this->output->setStandardOutFile('test');
        $this->assertEquals(' > test', $this->output->format());
    }

    /**
     * @test
     */
    public function shouldSetTheStandardErrorFile()
    {
        $this->output->setStandardErrorFile('test');
        $this->assertEquals(' 2> test', $this->output->format());
    }

    /**
     * @test
     */
    public function shouldSetBothOutputFiles()
    {
        $this->output->setStandardOutFile('test');
        $this->output->setStandardErrorFile('test');
        $this->assertEquals(' > test 2> test', $this->output->format());
    }
}