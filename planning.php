<?php

/*
 * For each client, an interval is set in configuration.
 * Planning selects a random minute in that interval, and stores
 * it in Redis. At that moment, a message is sent (reminder.php).
 */
use Carbon\Carbon;
use Predis\Client;

require __DIR__.'/bootstrap.php';

$redis = new Client;

foreach ($config['clients'] as $client) {
    // Parse period limits
    $start = Carbon::now('Europe/Amsterdam')->setTimeFromTimeString($client['moment']['from'])->getTimestamp();
    $end = Carbon::now('Europe/Amsterdam')->setTimeFromTimeString($client['moment']['till'])->getTimestamp();

    // pick a random point in that period
    $stamp = mt_rand($start, $end);
    $moment = Carbon::createFromTimestamp($stamp, 'Europe/Amsterdam');
    $moment->second = 0;

    // store that point in redis
    writeLog('Chose moment for ' . $client['number'] . ' to be ' . $moment->toISO8601String());
    $redis->set($client['number'], $moment->toISO8601String());
}
