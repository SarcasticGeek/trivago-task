<?php

namespace App\Constant;


class ItemCategory
{
    const HOTEL = 1;
    const ALTERNATIVE = 2;
    const HOSTEL = 3;
    const LODGE = 4;
    const RESORT = 5;
    const GUEST_HOUSE =6;

    /**
     * @return array
     */
    public function getItemCategories() {

        return [
            self::HOTEL => "hotel",
            self::ALTERNATIVE => "alternative",
            self::HOSTEL => "hostel",
            self::LODGE => "lodge",
            self::RESORT => "resort",
            self::GUEST_HOUSE => "guest-house",
        ];
    }

    /**
     * @param int $item
     *
     * @return string|null
     */
    public function getItemCategory(int $item) {

        return $this->getItemCategories()[$item]?: null;
    }
}
