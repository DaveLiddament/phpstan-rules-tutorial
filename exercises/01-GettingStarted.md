# Getting Started

This aim of this section is to create your first PHPStan rules. 
These will disallow language features, e.g. `echo`, `print`, `var_dump`, etc.


## Before you start

1. Make sure you have completed all the "Pre tutorial setup" steps in the [README](../README.md).
1. There is a 20-minute lecture that acts an introduction to the tutorial.

## Demo

Together we'll create a rule that disallows usages of `print`. 

#### Create code that calls print

Create a file `src/print.php` with the contents:

```php
<?php

print("This is not allowed");
```

#### Create a directory for storing PHPStan rules

For this tutorial we'll use `build\Phpstan\Rules`

Update `composer.json`, add following to `autoload-dev`:

```
 "DaveLiddament\\PhpstanTutorial\\Phpstan\\": "build/Phpstan/"
```

#### Create a rule

Create a new class `build\Phpstan\Rules\DontCallPrintRule.php`

```php
<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class DontCallPrintRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        var_dump(get_class($node));
        return [];
    }
}
```

Update `phpstan.neon` add a service section:

```yml
services:
-
    class: DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallPrintRule
    tags:
    - phpstan.rules.rule

```


Run PHPStan to dump out errors:

```
vendor/bin/phpstan analyse --debug src/print.php 
```

You should see something like this:
```
string(21) "PHPStan\Node\FileNode"
string(30) "PhpParser\Node\Stmt\Expression"
string(26) "PhpParser\Node\Expr\Print_"
string(29) "PhpParser\Node\Scalar\String_"
string(23) "PhpParser\Node\Stmt\Nop"
string(30) "PHPStan\Node\CollectedDataNode"
```

It is the `PhpParser\Node\Expr\Print_` node we want to look for. 

Update the rule:

```php
    public function getNodeType(): string
    {
        return Node\Expr\Print_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Don't call print")->build(),
        ];
    }
```

Rerun PHPStan, is it working how you expect?


## Your turn

Follow the process above to create rules to disallow:

- `echo`
- `die`
- `exit`
- `goto`
