<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\EntitySetIdOnlyCalledFromTestCodeRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\EntitySetIdOnlyCalledFromTestCodeRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<EntitySetIdOnlyCalledFromTestCodeRule> */
class EntitySetIdOnlyCalledFromTestCodeRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new EntitySetIdOnlyCalledFromTestCodeRule();
    }

    public function testCallSetIdFromTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/EntityTest.php',
            ],
            [],
        );
    }

    public function testCallSetIdOutsideOfTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                [
                    'Can not call Entity::setId outside of a test',
                    13,
                ]
            ],
        );
    }
}
