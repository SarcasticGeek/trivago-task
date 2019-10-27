<?php

namespace App\Repository;


interface ItemRepositoryInterface
{
    public function search(array $criteria = []): array;
}