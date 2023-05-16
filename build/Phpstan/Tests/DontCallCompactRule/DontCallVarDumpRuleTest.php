<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallCompactRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallCompactRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontCallCompactRule> */
class DontCallCompactRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallCompactRule();
    }

    public function testDontCallCompact(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/compact.php'], [
            [
                'Using compact is not allowed!',
                8,
            ],
        ]);
    }
}