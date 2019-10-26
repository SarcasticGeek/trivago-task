<?php

namespace App\Service;

use App\Entity\Item;

interface ItemManagerInterface
{
    public function getAll(): array;

    public function deleteOne(Item $item): bool;

    public function create(array $data);

    public function update(Item $item, string $data): Item;
}
