<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Print_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements  Rule<Print_> */
class DontCallPrintRule implements Rule
{
    public function getNodeType(): string
    {
        return Print_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't call print")->build(),
        ];
    }
}

