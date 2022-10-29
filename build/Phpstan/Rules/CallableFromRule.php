<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;


use DaveLiddament\PhpstanTutorial\CallableFrom;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

/** @implements Rule<\PhpParser\Node\Expr\MethodCall> */
class CallableFromRule implements Rule
{

    public function __construct(
        private ReflectionProvider $reflectionProvider,
    ) {
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $node->name instanceof Node\Identifier) {
            return [];
        }

        $methodName = $node->name->name;

        $callingClassName = $scope->getClassReflection()?->getName();

        if ($callingClassName === null) {
            return [];
        }

        $callingClassType = new ObjectType($callingClassName);

        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {
            $reflectedClass = $this->reflectionProvider->getClass($referencedClass);
            $nativeReflection = $reflectedClass->getNativeReflection();
            if (! $nativeReflection->hasMethod($methodName)) {
                continue;
            }
            $reflectedMethod = $nativeReflection->getMethod($methodName);
            $friendAttributes = $reflectedMethod->getAttributes(CallableFrom::class);
            foreach($friendAttributes as $friendAttribute) {
                $arguments = $friendAttribute->getArguments();
                if (count($arguments) !== 1) {
                    continue;
                }

                if (!$callingClassType->isInstanceOf($arguments[0])->yes()) {
                    return [
                        RuleErrorBuilder::message("Can not call method")->build(),
                    ];
                }
            }
        }

        return [];
    }
}
