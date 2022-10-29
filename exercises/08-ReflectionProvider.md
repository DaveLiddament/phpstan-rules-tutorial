# ReflectionProvider

Sometimes you'll need to write a rule that requires information about code that is not related to the node you are currently processing. 


## Demo

Look at the CallableFrom attribute.

#### Fixtures

`Item.php`:
```php
<?php
class Item
{
    public function __construct(
        private string $name,
    ) {
    }

    #[CallableFrom(ItemUpdater::class)]
    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
```

`ItemUpdater.php`
```php
class ItemUpdater
{
    public function updateName(Item $item, string $name): void
    {
        $item->updateName($name);
    }
}
```

`SomeCode.php`
```php
class SomeCode
{
    public function go(): void
    {
        $item = new Item("hello");
        $item->updateName("world"); // ERROR, not allowed
    }
}
```

##### Test

```php
class CallableFromRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new CallableFromRule($this->createReflectionProvider());
    }

    public function testInvalidCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/ItemUpdater.php',
            ],
            [
            ]
        );
    }

    public function testAllowedCall(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                [
                    "Can not call method",
                    12,
                ]
            ]
        );
    }
}
```


#### Rule

```php
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
```

## Your turn

Create a rule that allows you to restrict who can instantiate a new class E.g. 

```php


class Person
{
    #[CallableFrom(PersonBuilder::class)] 
    public function __construct()
    {
        // Only PersonBuilder can call this
    }
}

```
