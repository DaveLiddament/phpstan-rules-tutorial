<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

class NotAnEntity
{
    public function setId(): void
    {
    }
}