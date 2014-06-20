<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Formatter\Header;

class HeaderTest extends \PHPUnit_Framework_TestCase
{
    private $header;

    protected function setUp()
    {
        $this->header = new Header;
    }

    /**
     * @test
     */
    public function shouldAddMailToHeader()
    {
        $this->header->setMailTo('test@example.com');

        $expected = <<<EXP
MAILTO=test@example.com

EXP;
        $this->assertEquals($expected, $this->header->format());
    }

    /**
     * @test
     * @expectedException MyBuilder\Cronos\Formatter\InvalidEmail
     */
    public function invalidEmailOnSetMailShouldThrowException()
    {
        $this->header->setMailTo('invalid');
    }

    /**
     * @test
     */
    public function shouldAddHomeHeader()
    {
        $this->header->setHome('home');

        $expected = <<<EXP
HOME=home

EXP;
        $this->assertEquals($expected, $this->header->format());
    }

    /**
     * @test
     */
    public function shouldAddShell()
    {
        $this->header->setShell('shell');

        $expected = <<<EXP
SHELL=shell

EXP;
        $this->assertEquals($expected, $this->header->format());
    }

    /**
     * @test
     */
    public function shouldAddContentType()
    {
        $this->header->setContentType('text');

        $expected = <<<EXP
CONTENT_TYPE=text

EXP;
        $this->assertEquals($expected, $this->header->format());
    }

    /**
     * @test
     */
    public function shouldAddContentTransferEncoding()
    {
        $this->header->setContentTransferEncoding('utf8');

        $expected = <<<EXP
CONTENT_TRANSFER_ENCODING=utf8

EXP;
        $this->assertEquals($expected, $this->header->format());
    }
}
