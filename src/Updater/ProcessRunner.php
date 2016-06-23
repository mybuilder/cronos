<?php

namespace MyBuilder\Cronos\Updater;

interface ProcessRunner
{
    /**
     * @param string $command
     *
     * @return string
     */
    public function run($command);
}
