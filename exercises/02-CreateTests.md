# Adding tests

This shows how to create tests for your PHPStan rules. 


## Demo

Together we'll create a test for the rule that disallows usages of `print`. 

#### Create a directory for storing PHPStan rule tests

For this tutorial we'll use `build\Phpstan\Tests`

Update `phpunit.xml`, to include the PHPStan rule tests.

```
    <testsuite name="phpstan">
        <directory>build/Phpstan/Tests</directory>
    </testsuite>
```

#### Create a test for DontCallPrintRule 

First create a new directory: `build\Phpstan\Tests\DontCallPrintRule`

Create a new test `build\Phpstan\Tests\DontCallPrintRule\DontCallPrintRuleTest.php`

```php
<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallPrintRule;

use DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallPrintRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class DontCallPrintRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallPrintRule();
    }
}
```

#### Create a code sample for the test

Now we need to add a code snippet for test purposes. 
Let's create this in the directory `build\Phpstan\Tests\DontCallPrintRule\Fixtures`

Create sample code with a `print` statement in at `build\Phpstan\Tests\DontCallPrintRule\Fixtures\` 

```php
<?php

print("Hello world");
```

#### Add a test case


```php
    public function testDontCallVarDump(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/varDump.php'], [
            [
                'Using var_dump is not allowed!',
                5,
            ],
        ]);
    }
```



## Your turn

Create tests for the rules you created in step 1.
