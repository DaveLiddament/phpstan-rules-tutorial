<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallVarExportUnlessReturningStringRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallVarExportUnlessReturningStringOriginalRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallVarExportUnlessReturningStringOriginalRule> */
class DontCallVarExportUnlessReturningStringOriginalRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallVarExportUnlessReturningStringOriginalRule();
    }

    public function testSimpleCases(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/var_export.php',
            ],
            [
                [
                    'Using var_export is not allowed, unless returning string',
                    7,
                ],
                [
                    'Using var_export is not allowed, unless returning string',
                    8,
                ],
            ]
        );
    }
}
