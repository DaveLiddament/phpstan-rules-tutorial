# PHPStan rules tutorial

This repository contains the code to support [Dave Liddament](https://twitter.com/daveliddament)'s PHPStan rules tutorial.


## Pre tutorial setup

1. Set up an environment with either PHP 8.2 or 8.3.
1. Clone this repository.
1. Run: `composer install`
1. Run all the checks. There is a composer script for this: `composer run-script all-checks`

You should see something similar to this:

```
$ composer run-script all-checks
> phpstan analyse 
Note: Using configuration file /vagrant/phpstan.neon.
 5/5 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%


                                                                                                                       
 [OK] No errors                                                                                                        
                                                                                                                       

> phpunit
PHPUnit 9.5.26 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.18
Configuration: /vagrant/phpunit.xml

.                                                                   1 / 1 (100%)

Time: 00:00.015, Memory: 6.00 MB

OK (1 test, 1 assertion)

```

You're all good to go!


