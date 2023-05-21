<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;

/** @implements Rule<FuncCall> */
class DontCallVarExportUnlessReturningValueRule implements Rule
{
    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nameNode = $node->name;
        if (!$nameNode instanceof Node\Name) {
            return [];
        }

        if ($nameNode->toLowerString() !== 'var_export') {
            return [];
        }

        $secondArgument = $node?->args[1]->value ?? null;
        if ($secondArgument !== null) {
            $type = $scope->getType($secondArgument);
            if ($type instanceof ConstantBooleanType) {
                if ($type->getValue() === true) {
                    return [];
                }
            }
        }

        return [
            RuleErrorBuilder::message("Don't call var_export, unless returning result")->build(),
        ];
    }
}