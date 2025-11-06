<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GameValueEnum;

class BoardGame
{
    private static self $instance;

    /**
     * @var array<array<int, null|GameValueEnum|int>>
     */
    private array $matrix;

    private function __construct()
    {
        $this->matrix = [];
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        if (isset($_SESSION['matrix'])) {
            self::$instance->setMatrix($_SESSION['matrix']);
        }

        return self::$instance;
    }

    public function resetMatrix(): void
    {
        $this->matrix = [
            1 => [
                1 => null,
                2 => null,
                3 => null,
            ],
            2 => [
                1 => null,
                2 => null,
                3 => null,
            ],
            3 => [
                1 => null,
                2 => null,
                3 => null,
            ],
        ];

        $_SESSION['matrix'] = $this->matrix;
    }

    /**
     * @return array<array<int, null|GameValueEnum|int>>
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * @param array<array<int, null|GameValueEnum|int>> $matrix
     *
     * @return array<array<int, null|GameValueEnum|int>>
     */
    public function setMatrix(array $matrix): array
    {
        return $this->matrix = $matrix;
    }

    public function updateMatrix(int $i, int $j, GameValueEnum $valueEnum): void
    {
        if (isset($this->matrix[$i][$j]) && !empty($this->matrix[$i][$j])) {
            echo \sprintf('Already set matrix on position %s:%s', $i, $j);
        }
        $this->matrix[$i][$j] = $valueEnum;
        $_SESSION['matrix'] = $this->matrix;
    }
}
