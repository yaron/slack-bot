<?php
$router = \SlackBot\Services::load('Router');

$router->map('message', 'test', new \SlackBot\Route(), 'Beer@SlackBot\Controllers\BeerController');