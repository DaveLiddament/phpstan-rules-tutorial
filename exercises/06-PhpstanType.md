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

#### Don't call var_export, unless 2nd argument resolves to true

Make a rule that finds the errors in the code snippet below:

```php
<?php

var_export("Message"); // ERROR
var_export("Message", false); // ERROR
var_export("Message", true); // OK


function takesBool(bool $bool): void
{
    var_export("Message", $bool); // ERROR
    
    if ($bool === false) {
        return;
    }
    
    var_export("Message", $bool); // OK
}
```

Hint: Get a Type object of the second argument. Use `Type::isTrue()` method and report an error if this does not resolve to `yes`.



### Generalise PersonSetIdOnlyCalledFromTestCodeRule to any class implementing Entity

Generalise the `PersonSetIdOnlyCalledFromTestCodeRule` so that it works for any class that implements `Entity`.

