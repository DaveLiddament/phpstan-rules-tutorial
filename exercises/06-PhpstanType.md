# PHPStan\Type

We will look at a few slides about PHPStan\Type.


## Demo

Update `build/Phpstan/Rules/PersonSetIdOnlyCalledFromTestCodeRule.php`:

Before:
```php
        $currentClass = $scope->getClassReflection()?->getName();
        if ($currentClass !== null && str_ends_with($currentClass, 'Test')) {
            return [];
        }
```

Problem: what if we are in a class that ends with `Test` but is not a test class?

We really want to only consider classes that extend `TestCase`. We can do this using `ObjectType`:

After:
```php
        $currentClass = $scope->getClassReflection()?->getName();
        if ($currentClass !== null) {
            $objectType = new ObjectType($currentClass);
            $testClass = new ObjectType(TestCase::class);
            if ($testClass->isSuperTypeOf($objectType)->yes()) {
                return [];
            }
        }
```


## Your turn

Generalise the `PersonSetIdOnlyCalledFromTestCodeRule` so that it works for any class that implements `Entity`.

Don't forget, start by adding tests cases. 
