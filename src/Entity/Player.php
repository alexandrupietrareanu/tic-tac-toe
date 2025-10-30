<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class Player
{
    private GameValueEnum $type;
    private string $name;

    public function __construct() {}

    public function __toString(): string
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): GameValueEnum
    {
        return $this->type;
    }

    public function setType(GameValueEnum $type): self
    {
        $this->type = $type;

        return $this;
    }
}
