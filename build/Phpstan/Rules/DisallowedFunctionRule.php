<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements  Rule<FuncCall> */
class DisallowedFunctionRule implements Rule
{
    public function __construct(
        private string $disallowedFunctionName,
    ) {
    }

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

        if ($nameNode->toLowerString() !== $this->disallowedFunctionName) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Using {$this->disallowedFunctionName} is not allowed!")->build(),
        ];
    }
}

