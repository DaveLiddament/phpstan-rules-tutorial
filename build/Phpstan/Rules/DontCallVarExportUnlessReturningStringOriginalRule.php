<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<FuncCall>  */
class DontCallVarExportUnlessReturningStringOriginalRule implements Rule
{
    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->name instanceof Node\Name && $node->name->toLowerString() === 'var_export') {

            if (count($node->args) === 2) {
                $arg2 = $node->args[1];

                if ($arg2 instanceof Node\Arg) {
                    $value2 = $arg2->value;

                    if ($value2 instanceof Node\Expr\ConstFetch) {

                        if ($value2->name->toLowerString() === 'true') {
                            return [];
                        }
                    }
                }

            }

            return [
                RuleErrorBuilder::message('Using var_export is not allowed, unless returning string')->build(),
            ];
        }

        return [];
    }
}

