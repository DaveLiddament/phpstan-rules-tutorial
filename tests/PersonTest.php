<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Test;

use DaveLiddament\PhpstanTutorial\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    private const NAME = 'Dave';

    public function testGetName(): void
    {
        $person = new Person(self::NAME);
        $this->assertSame(self::NAME, $person->getName());
    }
}
