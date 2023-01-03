<?php

namespace MyBuilder\Cronos\Formatter;

class Header
{
    private ?string $path = null;
    private ?string $mailTo = null;
    private ?string $home = null;
    private ?string $shell = null;
    private ?string $contentType = null;
    private ?string $encoding = null;
    private ?string $timezone = null;

    public function __construct(private Cron $cron)
    {}

    /**
     * Works just like the shell PATH, but it does not inherit from your environment.
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function setHome(string $home): self
    {
        $this->home = $home;

        return $this;
    }

    /** @throws InvalidEmail if given email is invalid */
    public function setMailto(string $email): self
    {
        $this->assertValidEmail($email);
        $this->mailTo = $email;

        return $this;
    }

    private function assertValidEmail($email): void
    {
        if (false === \filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmail($email);
        }
    }

    /**
     * Set the shell to be used when executing commands
     *
     * Default is /bin/sh but can also be changed to /bin/php
     */
    public function setShell(string $shell): self
    {
        $this->shell = $shell;

        return $this;
    }

    /**
     * Set the content-type to use for cron output emails.
     */
    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Set the charset to use for cron output emails.
     */
    public function setContentTransferEncoding(string $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function format(): string
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
        if ($this->timezone) {
            $headers .= $this->createHeader('CRON_TZ', $this->timezone);
        }

        return $headers;
    }

    private function createHeader($name, $value): string
    {
        return $name . '=' . $value . \PHP_EOL;
    }

    public function end(): Cron
    {
        return $this->cron;
    }
}
