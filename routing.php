<?php
$router = \SlackBot\Services::load('Router');

$router->map('message', 'bier', new \SlackBot\Route(), 'Beer@SlackBot\Controllers\BeerController');