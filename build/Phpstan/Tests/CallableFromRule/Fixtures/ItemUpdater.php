<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\CallableFromRule\Fixtures;

class ItemUpdater
{
    public function updateName(Item $item, string $name): void
    {
        $item->updateName($name);
    }
}
