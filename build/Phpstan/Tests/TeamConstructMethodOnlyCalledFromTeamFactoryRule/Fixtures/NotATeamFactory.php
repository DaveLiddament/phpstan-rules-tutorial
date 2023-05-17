<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\TeamConstructMethodOnlyCalledFromTeamFactoryRule\Fixtures;

use DaveLiddament\PhpstanTutorial\Team;

class NotATeamFactory
{

    public function build(string $name): Team
    {
        return new Team($name); // ERROR: Not calling constructor from TeamFactory::build
    }

    public function anotherMethod(): void
    {
        $this->build('name');
    }
}