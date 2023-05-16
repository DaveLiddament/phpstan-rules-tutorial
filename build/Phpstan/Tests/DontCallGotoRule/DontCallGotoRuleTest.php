<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallGotoRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallGotoRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class DontCallGotoRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallGotoRule();
    }

    public function testDontGotoRule(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/goto.php'], [
            [
                "Don't call goto",
                3,
            ],
        ]);
    }
}

