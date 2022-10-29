<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial;


class TeamFactory
{

    public static function build(string $name): Team
    {
        return new Team($name);
    }
}
