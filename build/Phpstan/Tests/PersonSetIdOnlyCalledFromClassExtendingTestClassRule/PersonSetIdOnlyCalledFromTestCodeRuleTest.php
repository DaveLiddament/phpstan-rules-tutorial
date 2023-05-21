<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromClassExtendingTestClassRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\PersonSetIdOnlyCalledFromClassExtendingTestCaseRule;
use DaveLiddament\PhpstanTutorial\Phpstan\Rules\PersonSetIdOnlyCalledFromTestCodeRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<PersonSetIdOnlyCalledFromClassExtendingTestCaseRule> */
class PersonSetIdOnlyCalledFromTestCodeRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new PersonSetIdOnlyCalledFromClassExtendingTestCaseRule();
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
                    'Can not call Person::setId from a class that does not extend TestCase',
                    13,
                ],
            ],
        );
    }
}