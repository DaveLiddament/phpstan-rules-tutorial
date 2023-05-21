<?php

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use DaveLiddament\PhpstanTutorial\Person;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;

/** @implements Rule<Node\Expr\MethodCall> */
class PersonSetIdOnlyCalledFromClassExtendingTestCaseRule implements Rule
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

        $currentClass = $scope->getClassReflection()?->getName();
        if ($currentClass !== null) {
            $objectType = new ObjectType($currentClass);
            $testClass = new ObjectType(TestCase::class);
            if ($testClass->isSuperTypeOf($objectType)->yes()) {
                return [];
            }
        }
        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {
            if ($referencedClass === Person::class) {
                return [
                    RuleErrorBuilder::message('Can not call Person::setId from a class that does not extend TestCase')->build(),
                ];
            }

        }

        return [];
    }
}