# Create a disallow function call rule

Were going to create slightly more advanced rules. 
We will work through an example where we are interested in properties of a node.

We'll also start developing rules by writing the tests first. From this point on all rules should be written test first.

## Demo 

Create a rule that does not allow calls to `var_dump`

#### Create test code

Snippet: `build/Phpstan/Tests/DontCallVarDump/Fixtures/var_dump.php`

```php
<?php

var_dump("Don't do this");
```
Test: `build/Phpstan/Tests/DontCallVarDump/DontCallVarDumpRuleTest.php`

```php
class DontCallVarDumpTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DontCallVarDumpRule();
    }

    public function testDontCallVarDump(): void
    {
        $this->analyse([__DIR__ . '/Fixtures/varDump.php'], [
            [
                'Using var_dump is not allowed!',
                3,
            ],
        ]);
    }
}
```

#### Create empty rule

Rule: `build/Phpstan/DontCallVarDumpRule.php`

```php
class DontCallVarDumpRule implements Rule
{
    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(get_class($node))->build(),
        ];
    }
}
```

#### Update the rule

Run the test to see the output. Looks like we're interested in `FuncCall`. Let's update the rule...

```php
class DontCallVarDumpRule implements Rule
{
    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Using var_dump is not allowed!")->build(),
        ];
    }
}
```

#### Have we done the right thing?

A function call, can be for any function. What happens if we update our test snippet with another function call?

```php
<?php

var_dump("A message");

function isAdult(int $age): bool
{
    return $age >= 18;
}

isAdult(17);
```

Run tests. Get additional failure.

**TESTS MUST CHECK MORE THAN THE HAPPY PATH**

We need to check the name of the function we are calling too. Lets look at `FuncCall` in detail.

#### Get more information about the name node:

Update the rule to get more information about the `FuncCall`'s `name` node.

```php
    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message(get_class($node->name))->build(),
        ];
    }
```

#### Update the rule

```php
    public function processNode(Node $node, Scope $scope): array
    {
        $nameNode = $node->name;
        if (!$nameNode instanceof Node\Name) {
            return [];
        }

        if ($nameNode->toLowerString() !== 'var_dump') {
            return [];
        }

        return [
            RuleErrorBuilder::message('Using var_dump is not allowed!')->build(),
        ];
    }
```

Check everything works.

## Your turn

#### 1. Write a rule to disallow calls to compact

Follow steps we've just been through to create a rule that to disallow calls to `compact`.

#### 2. Write a rule to disallow var_export, unless 2nd argument is set to true.

Write a rule that reports errors as outlined below:

```php
<?php

var_export("This will is not allowed");  // ERROR

var_export("This is also not allowed", false);  // ERROR

$message = var_export("But this is OK", true);  // OK
```

#### 3. Can you think of some code where `FuncCall`'s `name` node will be of type `Expr`?

Write some code to demonstrate this. What do you think about code like this? If you don't like it write a rule to disallow code like this.
