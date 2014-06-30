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

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }
}
