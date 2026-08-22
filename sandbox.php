<?php

require __DIR__ . '/vendor/autoload.php';

use App\DatabaseConfig;

$config = new DatabaseConfig('db', '5432', 'app', 'app', 'secret');
echo $config->dsn(), "\n";