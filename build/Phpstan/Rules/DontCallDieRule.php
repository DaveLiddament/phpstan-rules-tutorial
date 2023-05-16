<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\Exit_> */
class DontCallDieRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\Exit_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->getAttribute('kind') !== Node\Expr\Exit_::KIND_DIE) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Don't call die")->build(),
        ];
    }
}