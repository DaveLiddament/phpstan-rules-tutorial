<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\TeamConstructMethodOnlyCalledFromTeamFactoryRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\PersonSetIdOnlyCalledFromTestCodeRule;
use DaveLiddament\PhpstanTutorial\Phpstan\Rules\TeamConstructMethodOnlyCalledFromTeamFactory;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<TeamConstructMethodOnlyCalledFromTeamFactory> */
class TeamConstructMethodOnlyCalledFromTeamFactoryTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new TeamConstructMethodOnlyCalledFromTeamFactory();
    }

    public function testCallNewTeamNotInTeamFactory(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/NotATeamFactory.php',
            ],
            [
                [
                    'Can only call new Team from TeamFactory::build',
                    14,
                ],
            ],
        );
    }

    public function testCallNewTeamInTeamFactory(): void
    {
        $this->analyse(
            [
                __DIR__ . '/../../../../src/TeamFactory.php',
            ],
            [
                // No errors
            ],
        );
    }
}