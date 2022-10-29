<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\CallableFromRule\Fixtures;

use DaveLiddament\PhpstanTutorial\CallableFrom;

class Item
{
    public function __construct(
        private string $name,
    ) {
    }

    #[CallableFrom(ItemUpdater::class)]
    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
