# Further challenges

Have a go at any of the following rules, or develop one that will be useful for your project. 

If you need any help after the tutorial then get in touch with Dave via [twitter](https://twitter.com/DaveLiddament)



## Create a rule to check all Controllers only have one public method called `__invoke`

Hint: You'll have to find the class node and then iterate through all its statements. 
Work out which ones are method calls and check method name and visibility.

## Create a rule that only does not allow magic numbers 

All integers can only be used in constants. 

E.g.

```php
const MAX_PLAYERS = 5; // OK

function processPlayers(int $players): void {
// Some implementation
}

processPlayers(5); // ERROR. Don't use magic numbers. 

```

Update so that some integer values are allowed (e.g. 0). The allowed numbers are defined in config.

## Create rules to make sure all public and protected methods are either final, abstract of have hook in the name

```php

abstract class Runner {

  final public function execute(): void {} // OK, method is final
  
  abstract protected function getName(): string; // OK. Method is abstract
  
  protected function updateNameHook(string $originalName): string // OK, method name ends with name Hook
  {
    return $originalName;
  }

  public function setOutput(): viod {} // ERROR.
}
```

Extend the rules to:

- make sure that any methods with names ending `Hook` are protected.
- if the class is final, there is no need to mark methods final.



## Implement a rule that would be useful on a project you're working on

Or, implement a rule for something that will be useful on what you are working on. 