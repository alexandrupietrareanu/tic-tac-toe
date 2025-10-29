<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class Player
{
    public function __construct(
        private GameValueEnum $type,
        private string $name,
    ) {}

    public function __toString(): string
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): GameValueEnum
    {
        return $this->type;
    }

    public function setType(GameValueEnum $type): void
    {
        $this->type = $type;
    }
}
