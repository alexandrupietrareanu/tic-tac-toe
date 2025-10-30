<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class BoardGame
{
    private static $instance;

    /**
     * @var array<array<int, null|GameValueEnum|int>>
     */
    private array $matrix;

    private function __construct()
    {
        $this->matrix = [];
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array<array<int, null|GameValueEnum|int>>
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    public function updateMatrix(int $i, int $j, GameValueEnum $valueEnum): void
    {
        if (isset($this->matrix[$i][$j]) && !empty($this->matrix[$i][$j])) {
            echo \sprintf('Already set matrix on position %s:%s', $i, $j);
        }
        $this->matrix[$i][$j] = $valueEnum;
    }
}
