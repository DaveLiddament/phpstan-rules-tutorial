<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\EntitySetIdOnlyCalledFromTestCodeRule\Fixtures;

class NotAnEntity
{
    public function setId(): void
    {
    }
}
