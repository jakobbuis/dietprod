<?php

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';
$twilio = new \Twilio\Rest\Client($config['twilio']['sip'], $config['twilio']['token']);

foreach ($config['clients'] as $client) {
    $message = $client['messages'][array_rand($client['messages'])];
    $twilio->messages->create($client['number'], [
        'from' => $config['twilio']['from_number'],
        'body' => $message,
    ]);
}
