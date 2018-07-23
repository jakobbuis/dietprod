<?php

use Twilio\Rest\Client;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__.'/config.php';
$twilio = new Client($config['twilio']['sip'], $config['twilio']['token']);

$twilio->messages->create('+31681130415', [
    'from' => $config['twilio']['from_number'],
    'body' => 'SMS delivery werkt',
]);

