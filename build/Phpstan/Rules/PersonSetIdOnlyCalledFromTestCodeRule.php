<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use DaveLiddament\PhpstanTutorial\Person;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/** @implements Rule<Node\Expr\MethodCall> */
class PersonSetIdOnlyCalledFromTestCodeRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Identifier) {
            return [];
        }

        if ($node->name->name !== 'setId') {
            return [];
        }

        // Exit if calling setId from a Test class.
        $currentClass = $scope->getClassReflection()?->getName();
        if ($currentClass !== null && str_ends_with($currentClass, 'Test')) {
            return [];
        }

        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {
            if ($referencedClass === Person::class) {
                return [
                    RuleErrorBuilder::message('Can not call Person::setId outside of a test')->build(),
                ];
            }

        }

        return [];
    }
}