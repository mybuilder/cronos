<?php

namespace MyBuilder\Cronos\Updater;

class FileSystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider availableFileSystems
     */
    public function shouldCreateTempFile($fileSystem)
    {
        $filename = $fileSystem->createTempFile('test', 'test content');

        $this->assertTrue(file_exists($filename));
        $this->assertEquals('test content', file_get_contents($filename));

        $fileSystem->removeFile($filename);

        $this->assertFalse(file_exists($filename));
    }

    public function availableFileSystems()
    {
        return array(
            array(new SymfonyFileSystem),
            array(new StandardFileSystem)
        );
    }
}