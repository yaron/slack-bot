<?php
require __DIR__ . '/vendor/autoload.php';
SlackBot\Services::init();
require __DIR__ . '/routing.php';

$bot = new SlackBot\Core();
$bot->connect();
