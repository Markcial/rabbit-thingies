<?php

require_once __DIR__ . '/vendor/autoload.php';

$receiver = new \Ulabox\Messaging\Receiver();
$receiver->listen();