<?php

namespace MyBuilder\Cronos\Updater;

use Symfony\Component\Process\Process;

class SymfonyProcessRunner implements ProcessRunner
{
    public function run(array $command): string
    {
        $process = new Process($command);
        $process->run();

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }
}
