<?php

namespace App\Service;


class DemoManager implements DemoManagerInterface
{

    public function hey(): string
    {
        return "Hello";
    }
}