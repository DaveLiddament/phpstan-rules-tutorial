<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallEchoRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallEchoRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class DontCallEchoRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallEchoRule();
    }

    public function testDontEchoRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/echo.php'], [
            [
                "Don't call echo",
                3,
            ],
        ]);
    }
}

