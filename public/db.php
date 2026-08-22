<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Visit;
use App\VisitRepository;
use Carbon\Carbon;
use App\Greeter;
use App\DatabaseConfig;

try {
    $config = new DatabaseConfig(
        getenv('DB_HOST'),
        (int) getenv('DB_PORT'),
        getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD')
    );

    $pdo = (new Database($config)->connect());
} catch (PDOException $e) {
    http_response_code(500);
    echo '<h1>Не удалось подключиться к базе</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    exit;
}

$visits = new VisitRepository($pdo);
$visits->createTable();
$visits->add();
$greeter = new Greeter();

echo '<h1>' . $greeter->stroka() . '</h1>';
echo '<h1>Подключение к PostgreSQL работает</h1>';
echo '<p>Всего визитов: <b>' . $visits->count() . '</b></p>';

echo '<h2>Последние 5 визитов</h2><ul>';
foreach ($visits->latest() as $visit) {
    echo '<li>#' . $visit->id . " — " . $visit->formattedDate() . '</li>';
}
echo '</ul>';
echo '<p>Сейчас в Москве: ' . Carbon::now('Europe/Moscow')->format('d.m.Y H:i') . '</p>';