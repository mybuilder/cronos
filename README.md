# Cronos

Easily configure cron through PHP.

If you use Symfony 4/5/6, you could use our [cool bundle](https://github.com/mybuilder/cronos-bundle) in order to configure your app jobs through fancy annotations!

## Setup and Configuration

Require the library via composer:

    composer require mybuilder/cronos

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
        ->appendStandardErrorToFile('error')
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
    1    2    3    4    5    /bin/bash command --env=dev > log 2>> error

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

* The current user must have a existing crontab file to use the updater, use `crontab -e` to create one.
* When a cron line is executed it is executed with the user that owns the crontab, but it will not execute any of the users default shell files so all paths etc need to be specified in the command called from the cron line.
* Your crontab will not be executed if you do not have usable shell in `/etc/passwd`
* If your jobs don't seem to be running, check the cron daemon is running, also check your username is in `/etc/cron.allow` and not in `/etc/cron.deny`.
* Environmental substitutions do not work, you cannot use things like `$PATH`, `$HOME`, or `~/sbin`.
* You cannot use `%` in the command, if you need to use it, escape the command in backticks.

---

Created by [MyBuilder](http://www.mybuilder.com/) - Check out our [blog](http://tech.mybuilder.com/) for more insight into this and other open-source projects we release.
