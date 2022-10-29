# Further challenges

Here are a some rules for you to develop.

## Don't call var_export, unless 2nd argument resolves to true

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

Hint: To check if an argument resolves to true you can use this code:

```php
    if ($arg instanceof Node\Arg) {
        if ($arg->value instanceof Node\Expr) {
            $type = $scope->getType($arg->value);
            if ($type instanceof ConstantBooleanType) {
                // Value will hold true or false
                $value = $type->getValue();
            }
        }
    }
```


## Create a rule to check all Controllers only have one public method called `__invoke`

Hint: You'll have to find the class node and then iterate through all its statements. 
Work out which ones are method calls and check method name and visibility.

## Implement a rule that would be useful on a project you're working on

