<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class DontCallGotoRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Goto_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't call goto")->build(),
        ];
    }
}