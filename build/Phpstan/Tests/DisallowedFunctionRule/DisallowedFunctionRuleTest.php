<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DisallowedFunctionRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DisallowedFunctionRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DisallowedFunctionRule> */
class DisallowedFunctionRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DisallowedFunctionRule('var_dump');
    }

    public function testDontCallVarDump(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/varDump.php'], [
            [
                'Using var_dump is not allowed!',
                3,
            ],
        ]);
    }
}
