<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallVarDumpRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallVarDumpRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallVarDumpRule> */
class DontCallVarDumpRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallVarDumpRule();
    }

    public function testDontCallVarDump(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/var_dump.php'], [
            [
                'Using var_dump is not allowed!',
                3,
            ],
        ]);
    }
}