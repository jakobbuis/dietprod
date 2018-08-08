<?php

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

function writeLog(string $message) : void
{
    syslog(LOG_INFO, 'Habitprod: ' . $message);
}
