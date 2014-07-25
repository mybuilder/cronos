<?php

namespace MyBuilder\Cronos\Formatter;

class Header
{
    /**
     * @var Cron
     */
    private $cron;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $mailTo;

    /**
     * @var string
     */
    private $home;

    /**
     * @var string
     */
    private $shell;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $encoding;

    /**
     * @param Cron $cron
     */
    public function __construct(Cron $cron)
    {
        $this->cron = $cron;
    }

    /**
     * Works just like the shell PATH, but it does not inherit from your environment.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $home
     *
     * @return $this
     */
    public function setHome($home)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     *
     * @throws InvalidEmail if given email is invalid
     */
    public function setMailto($email)
    {
        $this->assertValidEmail($email);
        $this->mailTo = $email;

        return $this;
    }

    private function assertValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmail($email);
        }
    }

    /**
     * Set the shell to be used when executing commands
     *
     * Default is /bin/sh but can also be changed to /bin/php
     *
     * @param string $shell
     *
     * @return $this
     */
    public function setShell($shell)
    {
        $this->shell = $shell;

        return $this;
    }

    /**
     * Set the content-type to use for cron output emails.
     *
     * @param string $contentType
     *
     * @return $this
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Set the charset to use for cron output emails.
     *
     * @param string $encoding
     *
     * @return $this
     */
    public function setContentTransferEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * @return string
     */
    public function format()
    {
        $headers = '';
        if ($this->path) {
            $headers .= $this->createHeader('PATH', $this->path);
        }
        if ($this->mailTo) {
            $headers .= $this->createHeader('MAILTO', $this->mailTo);
        }
        if ($this->home) {
            $headers .= $this->createHeader('HOME', $this->home);
        }
        if ($this->shell) {
            $headers .= $this->createHeader('SHELL', $this->shell);
        }
        if ($this->contentType) {
            $headers .= $this->createHeader('CONTENT_TYPE', $this->contentType);
        }
        if ($this->encoding) {
            $headers .= $this->createHeader('CONTENT_TRANSFER_ENCODING', $this->encoding);
        }

        return $headers;
    }

    private function createHeader($name, $value)
    {
        return $name . '=' . $value . PHP_EOL;
    }

    /**
     * @return Cron
     */
    public function end()
    {
        return $this->cron;
    }
}
