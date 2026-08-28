<?php

require __DIR__ . '/vendor/autoload.php';

use App\InMemoryVisitRepository;
use App\VisitRepository;
use App\VisitRepositoryInterface;
use App\DatabaseConfig;
use App\Database;

function vised(VisitRepositoryInterface $visitRepository): void
{
    echo 'Реализация: ', get_class($visitRepository), "\n";
    echo 'Всего: ', $visitRepository->count(), "\n";

    foreach ($visitRepository->latest(4) as $visit) {
        echo '#', $visit->id, ' - ', $visit->formattedDate(), "\n";
    }
}

$InMemory = new InMemoryVisitRepository();
$InMemory->add();
$InMemory->add();
$InMemory->add();
$InMemory->add();

$config = new DatabaseConfig(
    getenv('DB_HOST'),
    (int) getenv('DB_PORT'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
);

$pdo = new Database($config)->connect();
$InBase = new VisitRepository($pdo);

vised($InMemory);
echo "\n";
vised ($InBase);