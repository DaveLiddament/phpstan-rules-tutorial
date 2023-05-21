<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial;


/**
 * This is added to methods. You define the class that can call this method.
 *
 * E.g. if you had the following code `new Person` can only be called from code in the `PersonBuilder` class.
 *
 * ```php
 * class Person {
 *
 *   #[CallableFrom(PersonBuilder::class)]
 *   public function __construct() {
 *     // Some implementation
 *   }
 * }
 * ```
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class CallableFrom
{
    /** @param class-string $class */
    public function __construct(
        public string $class
    ) {}
}
