<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial;


#[\Attribute(\Attribute::TARGET_METHOD)]
class CallableFrom
{
    /** @param class-string $class */
    public function __construct(
        public string $class
    ) {}
}
