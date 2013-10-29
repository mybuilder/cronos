<?php

namespace MyBuilder\Cronos\Updater;

/**
 * Responsible for running processes
 */
interface ProcessRunner
{
    /**
     * Run the given command
     *
     * @param string $command
     *
     * @return boolean
     */
    public function run($command);
}
