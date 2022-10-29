<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\CallableFromRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\CallableFromRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class CallableFromRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new CallableFromRule($this->createReflectionProvider());
    }

    public function testInvalidCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ItemUpdater.php',
            ],
            [
            ]
        );
    }

    public function testAllowedCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                [
                    "Can not call method",
                    12,
                ]
            ]
        );
    }
}
