<?php

namespace App\Service;

use App\Entity\Item;

interface BookServiceInterface
{
    public function book(Item $item): bool;
}
