<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/app/Support/helpers.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

date_default_timezone_set(config('app.timezone'));
error_reporting(config('app.debug') ? E_ALL : 0);
ini_set('display_errors', config('app.debug') ? '1' : '0');

session_start();

$router = require dirname(__DIR__) . '/routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
