<?php

namespace App;

use PDO;

final class Database
{
    public function __construct(private DatabaseConfig $config)
    {
    }

    public function connect(): PDO
    {
        return new PDO(
            $this->config->dsn(),
            $this->config->user,
            $this->config->password,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
}
