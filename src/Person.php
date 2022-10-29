<?php

declare(strict_types=1);


namespace DaveLiddament\PhpstanTutorial;


class Person implements Entity
{
    private int $id;

    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


}
