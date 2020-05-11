<?php

namespace MyBuilder\Cronos\Updater;

interface ProcessRunner
{
    public function run(array $command): string;
}
