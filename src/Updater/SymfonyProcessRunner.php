<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Process\Process;

class SymfonyProcessRunner implements ProcessRunner
{
    /**
     * {@inheritdoc}
     */
    public function run($command)
    {
        $process = new Process($command);
        $process->run();

        return $process->isSuccessful();
    }
}
