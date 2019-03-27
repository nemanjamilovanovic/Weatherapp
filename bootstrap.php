<?php
if (PHP_SAPI !== 'cli') {
    session_start();
}

require 'vendor/autoload.php';
require 'database/Connection.php';
require 'UserManager.php';
require 'WeatherManager.php';
require 'WeatherApi.php';

$config = require 'config.php';

include 'googleconfig.php';

$pdo = Connection::getPDOConnection($config['database']);
$userManager = new UserManager($pdo);
$weatherManager = new WeatherManager($pdo);
