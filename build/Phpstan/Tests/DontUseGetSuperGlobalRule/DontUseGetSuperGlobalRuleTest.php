<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontUseGetSuperGlobalRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontUseGetSuperGlobalRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<DontUseGetSuperGlobalRule> */
class DontUseGetSuperGlobalRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontUseGetSuperGlobalRule();
    }

    public function testDontUseGetSuperGlobal(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/get.php'], [
            [
                "Don't use _GET superglobal",
                3,
            ],
            [
                "Don't use _GET superglobal",
                5,
            ],
            [
                "Don't use _GET superglobal",
                8,
            ],
        ]);
    }
}