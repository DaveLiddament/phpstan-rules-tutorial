<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallDie;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallDieRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallDieRule> */
class DontCallVarDumpTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallDieRule();
    }

    public function testDontCallVarDump(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/die.php'], [
            [
                'Using die is not allowed!',
                3,
            ],
        ]);
    }
}
