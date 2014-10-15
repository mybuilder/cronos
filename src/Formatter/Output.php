<?php

namespace MyBuilder\Cronos\Formatter;

class Output
{
    const NO_FILE = '/dev/null';

    /**
     * @var boolean
     */
    private $noOutput = false;

    /**
     * @var string
     */
    private $stdOutFile;

    /**
     * @var bool
     */
    private $stdOutAppend;

    /**
     * @var string
     */
    private $stdErrFile;

    /**
     * @var bool
     */
    private $stdErrAppend;

    /**
     * @return $this
     */
    public function suppressOutput()
    {
        $this->noOutput = true;

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setStandardOutFile($filePath)
    {
        $this->stdOutFile = $filePath;
        $this->stdOutAppend = false;

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function appendStandardOutToFile($filePath) {
        $this->stdOutFile = $filePath;
        $this->stdOutAppend = true;

        return $this;
    }

    /**
     * @param string $filePath
     * @param bool $append Either append or rewrite log file
     * @return $this
     */
    public function setStandardErrorFile($filePath, $append = false)
    {
        $this->stdErrFile = $filePath;
        $this->stdErrAppend = $append;

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function appendStandardErrorToFile($filePath) {
        $this->stdErrFile = $filePath;
        $this->stdErrAppend = true;

        return $this;
    }

    /**
     * @return string
     */
    public function format()
    {
        if ($this->noOutput) {
            return $this->redirectStandardOutTo(self::NO_FILE) . $this->redirectStandardErrorTo(self::NO_FILE);
        }

        return $this->createOutput();
    }

    private function redirectStandardOutTo($filePath)
    {
        return $this->redirectOutputTo('', $this->stdOutAppend, $filePath);
    }

    private function redirectOutputTo($out, $isAppend, $filePath)
    {
        $operator = $isAppend ? '>>' : '>';

        return ' ' . $out . $operator . ' '. $filePath;
    }

    private function redirectStandardErrorTo($filePath)
    {
        return $this->redirectOutputTo('2', $this->stdErrAppend, $filePath);
    }

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
}
