<?php

namespace MyBuilder\Cronos\Updater;

interface CronManipulator
{
    /*
     * @param $contents string
     */
    public function replace($contents);

    /**
     * @return string
     */
    public function getContent();
} 