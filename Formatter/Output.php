<?php

namespace MyBuilder\Cronos\Formatter;

/**
 * This class is responsible for formatting the output part of the config
 *
 * That then controls where the output from the executed command goes.
 */
class Output
{
    const NO_FILE = '/dev/null';
    /**
     * Should the output be suppressed
     *
     * @var boolean
     */
    private $noOutput = false;
    /**
     * @var string
     */
    private $stdOutFile;
    /**
     * @var string
     */
    private $stdErrFile;

    /**
     * Set the output to be suppressed
     *
     * @return $this
     */
    public function suppressOutput()
    {
        $this->noOutput = true;

        return $this;
    }

    /**
     * Set the location of the Standard Output File
     *
     * @param string $filePath
     *
     * @return $this
     */
    public function setStandardOutFile($filePath)
    {
        $this->stdOutFile = $filePath;

        return $this;
    }

    /**
     * Set the location of the Standard Error File
     *
     * @param string $filePath
     *
     * @return $this
     */
    public function setStandardErrorFile($filePath)
    {
        $this->stdErrFile = $filePath;

        return $this;
    }

    /**
     * Cron suitable output format
     *
     * @return string
     */
    public function format()
    {
        if ($this->noOutput) {
            return $this->redirectStandardOutTo(self::NO_FILE) . $this->redirectStandardErrorTo(self::NO_FILE);
        }

        return $this->createOutput();
    }

    /**
     * @return string
     */
    private function createOutput()
    {
        $out = '';
        if ($this->stdOutFile) {
            $out .= $this->redirectStandardOutTo($this->stdOutFile);
        }
        if ($this->stdErrFile) {
            $out .= $this->redirectStandardErrorTo($this->stdErrFile);
        }

        return $out;
    }

    /**
     * @param string $filePath
     *
     * @return string
     */
    private function redirectStandardOutTo($filePath)
    {
        return ' > ' . $filePath;
    }

    /**
     * @param string $filePath
     *
     * @return string
     */
    private function redirectStandardErrorTo($filePath)
    {
        return ' 2> ' . $filePath;
    }
}
