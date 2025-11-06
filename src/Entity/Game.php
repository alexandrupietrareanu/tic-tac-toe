<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class Game
{
    private static self $instance;
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
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        if (isset($_SESSION['limit'])) {
            self::$instance->setLimit($_SESSION['limit']);
        }

        if (isset($_SESSION['playerA'])) {
            self::$instance->setPlayerA($_SESSION['playerA']);
        }

        if (isset($_SESSION['playerB'])) {
            self::$instance->setPlayerB($_SESSION['playerB']);
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
        $_SESSION['playerA'] = $playerA;

        return $this;
    }

    public function getPlayerB(): Player
    {
        return $this->playerB;
    }

    public function setPlayerB(Player $playerB): self
    {
        $this->playerB = $playerB;
        $_SESSION['playerB'] = $playerB;

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
