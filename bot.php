<?php
require __DIR__ . '/vendor/autoload.php';

$config = new SlackBot\Config();
$router = new SlackBot\Router();
require __DIR__ . '/routing.php';

$bot = new SlackBot\Core($config, 'SlackBot\API', $router);
$bot->connect();
