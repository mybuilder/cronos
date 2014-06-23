<?php

namespace MyBuilder\Cronos\Updater;

use MyBuilder\Cronos\Formatter\Cron;

class CronUpdater
{
    const KEY_BEGIN = '# KEY %key%';
    const KEY_END = '# END';

    private $cronManipulator;

    public function __construct(CronManipulator $cronManipulator)
    {
        $this->cronManipulator = $cronManipulator;
    }

    /**
     * @return CronUpdater
     */
    public static function createDefault()
    {
        return new self(new CommandCronManipulator(new SymfonyProcessRunner, new StandardFileSystem));
    }

    /**
     * @param Cron $cron
     */
    public function replaceWith(Cron $cron)
    {
        $this->cronManipulator->replace($cron->format());
    }

    /**
     * @param Cron $cron
     * @param $key
     *
     * @throws \Exception
     */
    public function updateWith(Cron $cron, $key)
    {
        $this->cronManipulator->replace($this->updateContent($cron, $key));
    }

    private function updateContent(Cron $cron, $key)
    {
        $content = $this->cronManipulator->getContent();

        $count = 0;
        $pattern = '/\n' . $this->beginKey($key) . '.*?' . self::KEY_END . '/s';
        $replacedContent = preg_replace($pattern, $this->wrapInKey($cron, $key), $content, -1, $count);
        if ($count > 0) {
            return $replacedContent;
        }

        return $this->appendContent($cron, $key, $content);
    }

    private function wrapInKey(Cron $cron, $key)
    {
        return "\n" . $this->beginKey($key) . $cron->format() . self::KEY_END;
    }

    private function beginKey($key)
    {
        return str_replace('%key%', $key, self::KEY_BEGIN);
    }

    private function appendContent(Cron $cron, $key, $content)
    {
        return $content . $this->wrapInKey($cron, $key);
    }
}