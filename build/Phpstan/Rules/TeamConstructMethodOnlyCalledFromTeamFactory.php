<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use DaveLiddament\PhpstanTutorial\Team;
use DaveLiddament\PhpstanTutorial\TeamFactory;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\New_> */
class TeamConstructMethodOnlyCalledFromTeamFactory implements Rule
{

    public function getNodeType(): string
    {
        return Node\Expr\New_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($scope->getClassReflection()?->getName() === TeamFactory::class) {
            return [];
        }

        $name = $node->class;
        if (!$name instanceof Node\Name) {
            return [];
        }

        if ($name->toString() !== Team::class) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Can only call new Team from TeamFactory::build")->build(),
        ];
    }
}