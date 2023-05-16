<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallDieRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallDieRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class DontCallDieRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallDieRule();
    }

    public function testDontDieRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/die.php'], [
            [
                "Don't call die",
                3,
            ],
        ]);
    }
}

