# Add static analysis to rules

Just like your production and test code, PHPStan should be run on your custom rules, and the tests for them.


#### Update PHPStan config

Update paths section of `phpstan.neon`

```
    paths:
    - src
    - tests
    - build/Phpstan
    excludePaths:
    - build/Phpstan/*/Fixtures/*
```

#### Run PHPStan

```
vendor/bin/phpstan analyse
```


Issues found for the `DontCallPrintRule` and the corresponding test:

```
 ------ ------------------------------------------------------------------------------------------------------------------------------ 
  Line   build/Phpstan/Rules/DontCallPrintRule.php                                                                                     
 ------ ------------------------------------------------------------------------------------------------------------------------------ 
  12     Class DaveLiddament\PhpstanTutorial\Phpstan\Rules\DontCallPrintRule implements generic interface PHPStan\Rules\Rule but does  
         not specify its types: TNodeType                                                                                              
         💡 You can turn this off by setting checkGenericClassInNonGenericObjectType: false in your                                    
         phpstan.neon.                                                                                                                 
 ------ ------------------------------------------------------------------------------------------------------------------------------ 

 ------ ------------------------------------------------------------------------------------------------------------------------ 
  Line   build/Phpstan/Tests/DontCallGotoRule/DontCallPrintRuleTest.php                                                          
 ------ ------------------------------------------------------------------------------------------------------------------------ 
  11     Class DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallPrintRule\DontCallPrintRuleTest extends generic class         
         PHPStan\Testing\RuleTestCase but does not specify its types: TRule                                                      
         💡 You can turn this off by setting checkGenericClassInNonGenericObjectType: false in your                              
         phpstan.neon.                                                                                                           
  13     Method DaveLiddament\PhpstanTutorial\Phpstan\Tests\DontCallPrintRule\DontCallPrintRuleTest::getRule() return type with  
         generic interface PHPStan\Rules\Rule does not specify its types: TNodeType                                              
         💡 You can turn this off by setting checkGenericClassInNonGenericObjectType: false in your                              
         phpstan.neon.                                                                                                           
 ------ ------------------------------------------------------------------------------------------------------------------------ 
```

### Fix issues

Delete the initial `src/print.php` file, now that is covered by tests.


Update `build/Phpstan/Rules/DontCallPrintRule.php`:

```php
/** @implements Rule<Node\Expr\Print_> */
class DontCallPrintRule implements Rule
```

And `build/Phpstan/Tests/DontCallGotoRule/DontCallPrintRuleTest.php`:

```php
/** @extends RuleTestCase<DontCallPrintRule> */
class DontCallPrintRuleTest extends RuleTestCase
```



## Your turn

Run PHPStan and fix all issues it finds. 
