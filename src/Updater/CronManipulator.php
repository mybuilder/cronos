<?php

namespace MyBuilder\Cronos\Updater;

interface CronManipulator
{
    public function replace(string $contents): void;

    public function getContent(): string;
}
