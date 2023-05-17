<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\PersonSetIdOnlyCalledFromTestCodeRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<PersonSetIdOnlyCalledFromTestCodeRule> */
class PersonSetIdOnlyCalledFromTestCodeRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new PersonSetIdOnlyCalledFromTestCodeRule();
    }

    public function testCallSetIdFromTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/PersonTest.php',
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
                    'Can not call Person::setId outside of a test',
                    13,
                ],
            ],
        );
    }
}