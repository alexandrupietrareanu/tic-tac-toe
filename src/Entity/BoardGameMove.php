<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class BoardGameMove
{
    private int $length;
    private int $width;
    private GameValueEnum $value;
    private Player $player;

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getValue(): GameValueEnum
    {
        return $this->value;
    }

    public function setValue(GameValueEnum $value): void
    {
        $this->value = $value;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
