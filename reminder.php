<?php

use Carbon\Carbon;
use Twilio\Rest\Client;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$twilio = new Client($config['twilio']['sip'], $config['twilio']['token']);

foreach ($config['clients'] as $client) {
    // Determine if it's time for a message
    $moment = Carbon::now('Europe/Amsterdam')->format('Y-m-d')  . ' '  . $client['moment'];
    $now = Carbon::now('Europe/Amsterdam')->format('Y-m-d H:i');
    if ($moment !== $now) {
        writeLog('Not sending message to ' . $client['number']);
        continue;
    }

    // Send a message
    writeLog(LOG_INFO, 'Sending message to ' . $client['number']);
    $message = $client['messages'][array_rand($client['messages'])];
    $twilio->messages->create($client['number'], [
        'from' => $config['twilio']['from_number'],
        'body' => $message,
    ]);
}

function writeLog(string $message, int $level = LOG_INFO) : void
{
    syslog($level, 'Habitprod: ' . $message);
}
