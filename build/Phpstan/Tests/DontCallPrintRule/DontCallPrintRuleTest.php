<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallPrintRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallPrintRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class DontCallPrintRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallPrintRule();
    }

    public function testDontPrintRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/print.php'], [
            [
                "Don't call print",
                3,
            ],
        ]);
    }
}

