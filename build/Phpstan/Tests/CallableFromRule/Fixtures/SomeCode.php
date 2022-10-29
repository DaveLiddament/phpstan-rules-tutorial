<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\CallableFromRule\Fixtures;

class SomeCode
{
    public function go(): void
    {
        $item = new Item("hello");
        $item->updateName("world"); // ERROR, not allowed
    }
}
