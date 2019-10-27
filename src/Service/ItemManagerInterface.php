<?php

namespace App\Service;

use App\Entity\Item;

interface ItemManagerInterface
{
    public function getAll(): array;

    public function deleteOne(Item $item): bool;

    public function create(array $data): array;

    public function update(Item $item, array $data): array;
}
