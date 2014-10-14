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
     * @return $this
     */
    public function appendOutput()
    {
        $this->stdErrAppend = true;
        $this->stdOutAppend = true;

        return $this;
    }

    /**
     * @param string $filePath
     * @param bool $append Either append or rewrite log file
     *
     * @return $this
     */
    public function setStandardOutFile($filePath, $append = false)
    {
        $this->stdOutFile = $filePath;
        $this->stdOutAppend = $append;

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
        $redirectOperator = $this->getRedirectOperator($this->stdOutAppend);

        return sprintf(' %s %s', $redirectOperator, $filePath);
    }

    /**
     * @param string $filePath
     *
     * @return string
     */
    private function redirectStandardErrorTo($filePath)
    {
        $redirectOperator = $this->getRedirectOperator($this->stdErrAppend);

        return sprintf(' 2%s %s', $redirectOperator, $filePath);
    }

    private function getRedirectOperator($append)
    {
        $redirectOperator = '>';
        if ($append) {
            $redirectOperator = '>>';
        }

        return $redirectOperator;
    }


}
