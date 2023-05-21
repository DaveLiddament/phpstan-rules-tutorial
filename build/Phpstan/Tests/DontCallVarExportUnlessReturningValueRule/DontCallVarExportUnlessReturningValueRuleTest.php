<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallVarExportUnlessReturningValueRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallVarExportUnlessReturningValueRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallVarExportUnlessReturningValueRule> */
class DontCallVarExportUnlessReturningValueRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new DontCallVarExportUnlessReturningValueRule();
    }

    public function testDontUseGetSuperGlobal(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/var_exports.php'], [
            [
                "Don't call var_export, unless returning result",
                3,
            ],
            [
                "Don't call var_export, unless returning result",
                4,
            ],
            [
                "Don't call var_export, unless returning result",
                10,
            ],
        ]);
    }
}