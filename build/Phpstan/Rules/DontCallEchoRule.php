<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class DontCallEchoRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Echo_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't call echo")->build(),
        ];
    }
}