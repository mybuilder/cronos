<?php

namespace MyBuilder\Cronos\Formatter;

class Output
{
    public const NO_FILE = '/dev/null';
    private bool $noOutput = false;
    private ?string $stdOutFile = null;
    private bool $stdOutAppend = false;
    private ?string $stdErrFile = null;
    private bool $stdErrAppend = false;

    public function suppressOutput(): self
    {
        $this->noOutput = true;

        return $this;
    }

    public function setStandardOutFile(string $filePath): self
    {
        $this->stdOutFile = $filePath;
        $this->stdOutAppend = false;

        return $this;
    }

    public function appendStandardOutToFile(string $filePath): self
    {
        $this->stdOutFile = $filePath;
        $this->stdOutAppend = true;

        return $this;
    }

    /**
     * @param bool $append Either append or rewrite log file
     */
    public function setStandardErrorFile(string $filePath, bool $append = false): self
    {
        $this->stdErrFile = $filePath;
        $this->stdErrAppend = $append;

        return $this;
    }

    public function appendStandardErrorToFile(string $filePath): self
    {
        $this->stdErrFile = $filePath;
        $this->stdErrAppend = true;

        return $this;
    }

    public function format(): string
    {
        if ($this->noOutput) {
            return $this->redirectStandardOutTo(self::NO_FILE) . $this->redirectStandardErrorTo(self::NO_FILE);
        }

        return $this->createOutput();
    }

    private function redirectStandardOutTo($filePath): string
    {
        return $this->redirectOutputTo('', $this->stdOutAppend, $filePath);
    }

    private function redirectOutputTo($out, $isAppend, $filePath): string
    {
        $operator = $isAppend ? '>>' : '>';

        return ' ' . $out . $operator . ' ' . $filePath;
    }

    private function redirectStandardErrorTo($filePath): string
    {
        return $this->redirectOutputTo('2', $this->stdErrAppend, $filePath);
    }

    private function createOutput(): string
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
