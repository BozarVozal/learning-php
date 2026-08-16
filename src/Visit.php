<?php

namespace App;

use DateTimeImmutable;

class Visit
{
    public function __construct(public readonly int $id, public readonly DateTimeImmutable $visitedAt)
    {
    }

    public function formattedDate(): string
    {
        return $this->visitedAt->format('d.m.Y H:i');
    }
}