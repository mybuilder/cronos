<?php

namespace MyBuilder\Cronos\Updater;

interface ProcessRunner
{
    /**
     * @param string $command
     *
     * @return boolean
     */
    public function run($command);
}
