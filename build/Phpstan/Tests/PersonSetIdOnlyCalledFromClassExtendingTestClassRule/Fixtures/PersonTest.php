<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromClassExtendingTestClassRule\Fixtures;

use DaveLiddament\PhpstanTutorial\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testSetId(): void
    {
        $companyEntity = new Person("bob");
        $companyEntity->setId(7); // OK
        $this->assertSame(7, $companyEntity->getId());
    }
}