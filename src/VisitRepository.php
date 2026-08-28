<?php

namespace App;

use PDO;
use DateTimeImmutable;

class VisitRepository implements VisitRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createTable(): void
    {
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS visits (
                id SERIAL PRIMARY KEY,
                visited_at TIMESTAMP NOT NULL DEFAULT NOW()
            )
        ');
    }

    public function add(): void
    {
        $this->pdo->exec('INSERT INTO visits DEFAULT VALUES');
    }

    public function count(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
    }

    /** @return $visits */
    public function latest(int $limit = 5): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, visited_at FROM visits ORDER BY id DESC LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $visits = [];
        foreach ($stmt->fetchAll() as $raw) {
            $visits[] = new Visit($raw['id'], new DateTimeImmutable($raw['visited_at']));
        }
        return $visits;
    }
}
