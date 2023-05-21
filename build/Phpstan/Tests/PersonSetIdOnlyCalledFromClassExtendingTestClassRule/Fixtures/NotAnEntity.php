<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromClassExtendingTestClassRule\Fixtures;

class NotAnEntity
{
    public function setId(): void
    {
    }
}