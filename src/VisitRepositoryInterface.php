<?php

namespace App;

interface VisitRepositoryInterface
{
   public function add(): void;

   public function count(): int;

   /** @return Visit[] */
   public function latest(int $limit = 5): array;


}