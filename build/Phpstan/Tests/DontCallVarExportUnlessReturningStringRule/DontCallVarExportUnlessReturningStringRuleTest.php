<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallVarExportUnlessReturningStringRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallVarExportUnlessReturningStringRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallVarExportUnlessReturningStringRule> */
class DontCallVarExportUnlessReturningStringRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallVarExportUnlessReturningStringRule();
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

    public function testScopeUpdates(): void
    {

        $this->analyse(
            [
                __DIR__ . '/Fixtures/var_export_if_statement.php',
            ],
            [
                [
                    'Using var_export is not allowed, unless returning string',
                    5,
                ],
            ]
        );
    }

}
