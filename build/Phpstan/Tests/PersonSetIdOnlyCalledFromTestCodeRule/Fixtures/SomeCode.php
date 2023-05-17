<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

use DaveLiddament\PhpstanTutorial\Person;

class SomeCode
{
    public function setIdOnEntity(Person $entity): void
    {
        $entity->setId(7); // ERROR, not allowed
    }

    public function setIdOnNoneEntity(NotAnEntity $notAnEntity): void
    {
        $notAnEntity->setId();
    }


}