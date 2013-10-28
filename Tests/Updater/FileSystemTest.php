<?php

namespace MyBuilder\Cronos\Tests\Formatter;

use MyBuilder\Cronos\Updater\FileSystem;

/**
 * FileSystemTest
 */
class FileSystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileSystem
     */
    private $object;

    public function setUp()
    {
        $this->object = new FileSystem();
    }

    public function testFilesystem()
    {
        $filename = $this->object->createTempFile('test', 'test content');

        $this->assertTrue(file_exists($filename));
        $this->assertEquals('test content', file_get_contents($filename));

        $this->object->removeFile($filename);

        $this->assertFalse(file_exists($filename));
    }
}
 