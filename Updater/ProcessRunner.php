<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Process\Process;

/**
 * Responsible for running processes
 */
class ProcessRunner
{
    /**
     * Run the given command
     *
     * @param string $command
     *
     * @return boolean
     */
    public function run($command)
    {
        $process = new Process($command);
        $process->run();

        return $process->isSuccessful();
    }
}
