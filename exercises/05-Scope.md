# Scope

PHPStan can give us type information about variables. Sometimes we want to know this information to write rules.


## Demo

Assume our project has a Person entity, it has an ID, which is set by the database. 
Some of our unit tests need to set the ID. As they are unit tests the database is not used, so the database cannot assign an ID to the entity.
Instead, we must expose a Person::setId. This should only ever be called by test code. 

We are going to write a rule that only allows Person::setId to be called by test code.

#### Setup simple rule

Empty rule `build/Phpstan/Rules/PersonSetIdOnlyCalledFromTestCodeRule`:

```php
class PersonSetIdOnlyCalledFromTestCodeRule implements Rule
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

#### Setup fixtures

Fixtures `build/Phpstan/Tests/PersonSetIdOnlyCalledFromTestCodeRule/Fixtures`:


`NotAnEntity.php`
```php
<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

class NotAnEntity
{
    public function setId(): void
    {
    }
}
```
---

`PersonTest.php`

```php
<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

use DaveLiddament\PhpstanTutorial\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testSetId(): void
    {
        $companyEntity = new Person("bob");
        $companyEntity->setId(7); // OK
        $this->assertSame(7, $companyEntity->getId());
    }
}
```

---

`SomeCode.php`

```php
<?php

declare(strict_types=1);

namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule\Fixtures;

use DaveLiddament\PhpstanTutorial\Person;

class SomeCode
{
    public function setIdOnEntity(Person $entity): void
    {
        $entity->setId(7); // ERROR, not allowed
    }

    public function setIdOnNoneEntity(NotAnEntity $notAnEntity): void
    {
        $notAnEntity->setId();
    }
}
```


### Create test

Test `build/Phpstan/Tests/PersonSetIdOnlyCalledFromTestCodeRule/PersonSetIdOnlyCalledFromTestCodeRuleTest`:

```php
<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial\Phpstan\Tests\PersonSetIdOnlyCalledFromTestCodeRule;


use DaveLiddament\PhpstanTutorial\Phpstan\Rules\PersonSetIdOnlyCalledFromTestCodeRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/** @extends RuleTestCase<PersonSetIdOnlyCalledFromTestCodeRule> */
class PersonSetIdOnlyCalledFromTestCodeRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new PersonSetIdOnlyCalledFromTestCodeRule();
    }

    public function testCallSetIdFromTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/PersonTest.php',
            ],
            [],
        );
    }

    public function testCallSetIdOutsideOfTest(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/SomeCode.php',
            ],
            [
                'Can not call Person::setId outside of a test',
                13,
            ],
        );
    }
}
```

#### Interested in `MethodCall` Node

Look at `MethodCall`


#### Look at scope

Need it to tell us

1. Class we are in.
2. Class of `MethodCall`'s `$var` member data.


#### Update test

```php
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->name instanceof Node\Identifier) {
            return [];
        }

        if ($node->name->name !== 'setId') {
            return [];
        }

        // Exit if calling setId from a Test class.
        $currentClass = $scope->getClassReflection()?->getName();
        if ($currentClass !== null && str_ends_with($currentClass, 'Test')) {
            return [];
        }

        foreach ($scope->getType($node->var)->getReferencedClasses() as $referencedClass) {
            if ($referencedClass === Person::class) {
                return [
                    RuleErrorBuilder::message('Can not call Person::setId outside of a test')->build(),
                ];
            }

        }

        return [];
    }
```

## Your turn

Create a rule to enforce that `Team` can only be constructed within `TeamBuilder`.

