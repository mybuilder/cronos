<?php

namespace MyBuilder\Cronos\Updater;

use MyBuilder\Cronos\Formatter\Cron;

class CronUpdater
{
    public const KEY_BEGIN = '# KEY %key%';
    public const KEY_END = '# END';

    public function __construct(private CronManipulator $cronManipulator)
    {}

    public static function createDefault(): self
    {
        return new self(new CommandCronManipulator(new SymfonyProcessRunner, new StandardFileSystem));
    }

    public function replaceWith(Cron $cron): void
    {
        $this->cronManipulator->replace($cron->format());
    }

    public function updateWith(Cron $cron, string $key): void
    {
        $this->cronManipulator->replace($this->updateContent($cron, $key));
    }

    private function updateContent(Cron $cron, string $key): string
    {
        $content = $this->cronManipulator->getContent();

        $count = 0;
        $pattern = '/\r?\n' . $this->beginKey($key) . '.*?' . self::KEY_END . '/s';
        $replacedContent = \preg_replace($pattern, $this->wrapInKey($cron, $key), $content, -1, $count);

        if ($count > 0) {
            return $replacedContent;
        }

        return $this->appendContent($cron, $key, $content);
    }

    private function wrapInKey(Cron $cron, string $key): string
    {
        return \PHP_EOL . $this->beginKey($key) . \PHP_EOL . \trim($cron->format()) . \PHP_EOL . self::KEY_END;
    }

    private function beginKey(string $key): string
    {
        return \str_replace('%key%', $key, self::KEY_BEGIN);
    }

    private function appendContent(Cron $cron, string $key, string $content): string
    {
        return $content . $this->wrapInKey($cron, $key) . \PHP_EOL;
    }
}
