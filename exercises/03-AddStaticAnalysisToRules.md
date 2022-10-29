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

## Your turn

Run PHPStan and fix all issues it finds. You might want to delete the initial `src/print.php` file, now that is covered by tests.
