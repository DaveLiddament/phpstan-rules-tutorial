<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;

/** @implements Rule<FuncCall> */
class DontCallVarExportUnlessReturningStringRule implements Rule
{
    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Name) {
            return [];
        }

        if ($node->name->toLowerString() !== 'var_export') {
            return [];
        }

        if (count($node->args) === 2) {

            $arg2 = $node->args[1];

            if ($arg2 instanceof Node\Arg) {

                if ($arg2->value instanceof Node\Expr) {

                    $type = $scope->getType($arg2->value);
                    if ($type instanceof ConstantBooleanType) {
                        if ($type->getValue() === true) {
                            return [];
                        }
                    }


                }
            }

        }

        return [
            RuleErrorBuilder::message('Using var_export is not allowed, unless returning string')->build(),
        ];
    }
}

