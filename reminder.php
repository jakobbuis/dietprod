<?php

use Carbon\Carbon;
use Twilio\Rest\Client;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$twilio = new Client($config['twilio']['sip'], $config['twilio']['token']);

foreach ($config['clients'] as $client) {
    // Determine if it's time for a message
    $moment = Carbon::now()->format('Y-m-d')  . ' '  . $client['moment'];
    $now = Carbon::now()->format('Y-m-d H:i');
    if ($moment !== $now) {
        echo 'Not sending message to '.$client['number'] . PHP_EOL;
        continue;
    }

    // Send a message
    echo 'Sending message to '.$client['number'] . PHP_EOL;
    $message = $client['messages'][array_rand($client['messages'])];
    $twilio->messages->create($client['number'], [
        'from' => $config['twilio']['from_number'],
        'body' => $message,
    ]);
}
