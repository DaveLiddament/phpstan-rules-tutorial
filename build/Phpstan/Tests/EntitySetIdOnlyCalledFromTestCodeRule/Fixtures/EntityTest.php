<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\EntitySetIdOnlyCalledFromTestCodeRule\Fixtures;

use DaveLiddament\PhpstanTutorial\Person;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testSetId(): void
    {
        $companyEntity = new Person("bob");
        $companyEntity->setId(7); // OK
        $this->assertSame(7, $companyEntity->getId());
    }
}
