<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallExitRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallExitRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallExitRule> */
class DontCallExitRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallExitRule();
    }

    public function testDontExitRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/exit.php'], [
            [
                "Don't call exit",
                3,
            ],
        ]);
    }
}

