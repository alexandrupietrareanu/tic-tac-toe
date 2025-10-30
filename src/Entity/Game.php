<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class Game
{
    private static $instance;
    private ?Player $winner = null;

    private Player $playerA;

    private Player $playerB;

    private int $limit;

    private string $name;

    private function __construct()
    {
        $this->name = 'TicTacToe';
        $this->playerA = new Player();
        $this->playerA->setType(GameValueEnum::X);
        $this->playerB = new Player();
        $this->playerB->setType(GameValueEnum::O);
        // Private constructor to prevent instantiation outside the class
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getPlayerA(): Player
    {
        return $this->playerA;
    }

    public function setPlayerA(Player $playerA): self
    {
        $this->playerA = $playerA;

        return $this;
    }

    public function getPlayerB(): Player
    {
        return $this->playerB;
    }

    public function setPlayerB(Player $playerB): self
    {
        $this->playerB = $playerB;

        return $this;
    }

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner): void
    {
        $this->winner = $winner;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
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
}
