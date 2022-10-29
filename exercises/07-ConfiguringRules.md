# Configuring rules

We often have multiple rules that  are very similar to each other. 
Or maybe we have rules that require configuration.

## Demo

In the previous exercise we wrote a rule that disallows calls to `var_dump` and `compact`. 
Let's make a generic version of the rule that allows us to configure the functions that are disallowed.

#### Create generic rule

Rule: `build/Phpstan/Rules/DisallowFunctionRule.php`

```php
/** @implements  Rule<FuncCall> */
class DisallowFunctionRule implements Rule
{
    public function __construct(
        private string $disallowedFunction
    ) {
    }

    public function getNodeType(): string
    {
        return FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $nameNode = $node->name;
        if (!$nameNode instanceof Node\Name) {
            return [];
        }

        if ($nameNode->toLowerString() !== $this->disallowedFunction) {
            return [];
        }

        return [
            RuleErrorBuilder::message("Using {$this->disallowedFunction} is not allowed!")->build(),
        ];
    }
}
```

#### Update config

Update PHPStan config `phpstan.neon`:

```
services:
-
    class: DaveLiddament\PhpstanTutorial\Phpstan\Rules\DisallowedFunctionRule
    tags:
    - phpstan.rules.rule
    arguments:
      disallowedFunctionName: 'var_dump'

-
    class: DaveLiddament\PhpstanTutorial\Phpstan\Rules\DisallowedFunctionRule
    tags:
    - phpstan.rules.rule
    arguments:
      disallowedFunctionName: 'compact'
```

## Your turn

Generalise the `PersonSetIdOnlyCalledFromTestCodeRule` so you can configure class name and method name
