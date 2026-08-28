<?php

namespace App;

use DateTimeImmutable;

final class InMemoryVisitRepository implements VisitRepositoryInterface
{
    /** @var Visit[] */
    private array $visits = [];

    private int $nextId = 1;

    public function add(): void
    {
        $this->visits[] = new Visit($this->nextId, new DateTimeImmutable());
        $this->nextId++;
    }

    public function count(): int
    {
        return count($this->visits);
    }

    public function latest(int $limit = 5): array
    {
        return array_slice(array_reverse($this->visits), 0, $limit);
    }
}