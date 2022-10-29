<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use DaveLiddament\PhpstanTutorial\Entity;
use DaveLiddament\PhpstanTutorial\Person;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;

/** @implements Rule<\PhpParser\Node\Expr\MethodCall> */
class EntitySetIdOnlyCalledFromTestCodeRule implements Rule
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
        if ($currentClass !== null) {
            $objectType = new ObjectType($currentClass);
            $testClass = new ObjectType(TestCase::class);
            if ($testClass->isSuperTypeOf($objectType)->yes()) {
                return [];
            }
        }

        $entityType = new ObjectType(Entity::class);

        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {
            if ($entityType->isSuperTypeOf(new ObjectType($referencedClass))->yes()) {
                return [
                    RuleErrorBuilder::message('Can not call Entity::setId outside of a test')->build(),
                ];
            }

        }

        return [];
    }
}
