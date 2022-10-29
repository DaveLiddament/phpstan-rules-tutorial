<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallVarDump;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallVarDumpRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallVarDumpRule> */
class DontCallVarDumpTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallVarDumpRule();
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
