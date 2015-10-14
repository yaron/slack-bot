<?php
require __DIR__ . '/vendor/autoload.php';

$config = new SlackBot\Config();
$bot = new SlackBot\Core($config);
$bot->connect();
