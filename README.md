# Cronos

[![Build Status](https://secure.travis-ci.org/mybuilder/cronos.svg?branch=master)](http://travis-ci.org/mybuilder/cronos)

Configure Cron task through PHP.

## Usage

### Build Cron
```php
<?php

require 'vendor/autoload.php';

$cron = new MyBuilder\Cronos\Formatter\Cron;
$cron
    ->header()
        ->setPath('path')
        ->setHome('home')
        ->setMailto('test@example.com')
        ->setShell('shell')
        ->setContentType('text')
        ->setContentTransferEncoding('utf8')
    ->end()
    ->comment('Comment')
    ->job('/bin/bash command --env=dev')
        ->setMinute(1)
        ->setHour(2)
        ->setDayOfMonth(3)
        ->setMonth(4)
        ->setDayOfWeek(5)
        ->setStandardOutFile('log')
        ->setStandardErrorFile('error')
    ->end();

echo $cron->format();
```

That will print

    MAILTO=test@example.com
    HOME=home
    SHELL=shell
    LOGNAME=logName
    CONTENT_TYPE=text
    CONTENT_TRANSFER_ENCODING=utf8

    #Comment
    1    2    3    4    5    /bin/bash command --env=dev > log 2> error

### Updating Cron

```php
<?php

require 'vendor/autoload.php';

use MyBuilder\Cronos\Formatter\Cron;
use MyBuilder\Cronos\Updater\CronUpdater;

$cron = new Cron;
// $cron configuration...

$cronUpdater = CronUpdater::createDefault();
$cronUpdater->replaceWith($cron);
```

## Troubleshooting

* When a cron line is executed it is executed with the user that owns the crontab, but it will not execute any of the users default shell files so all paths etc need to be specified in the command called from the cron line.
* Your crontab will not be executed if you do not have useable shell in /etc/passwd
* If your jobs don't seem to be running check that the cron deamon is running, also check your username is in /etc/cron.allow and not in /etc/cron.deny.
* Environmental substitutions do not work, you can not use things like $PATH, $HOME, or ~/sbin.
* You can not use % in the command, if you need to use it escape the command in backticks.
