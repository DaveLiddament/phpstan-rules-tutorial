<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\ArrayDimFetch> */
class DontUseGetSuperGlobalRule implements Rule
{

    public function getNodeType(): string
    {
        return Node\Expr\ArrayDimFetch::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {

        if (!$node->var instanceof Node\Expr\Variable) {
            return [];
        }

        if ($node->var->name !== '_GET') {
            return [];
        }


        return [
            RuleErrorBuilder::message("Don't use _GET superglobal")->build(),
        ];
    }
}