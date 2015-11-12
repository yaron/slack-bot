<?php
$router = \SlackBot\Services::load('Router');

$router->map('message', 'bier', new \SlackBot\Route(), 'Beer@SlackBot\Controllers\BeerController');
$router->map('message', '!youtube *', new \SlackBot\Route(), 'Youtube@SlackBot\Controllers\YoutubeController');