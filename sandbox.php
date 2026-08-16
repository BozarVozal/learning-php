<?php

require __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\VisitRepository;

$repo = new VisitRepository(Database::connect());
foreach ($repo->latest(3) as $visit) {
    echo '#', $visit->id, ' — ', $visit->formattedDate(), "\n";
}