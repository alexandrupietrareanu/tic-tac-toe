<?php

declare(strict_types=1);

namespace tests;

use App\Controller\HomeController;
use App\Service\GameService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class HomeControllerTest extends TestCase
{
    public function testIndexOutputsWelcome(): void
    {
        $gameService = $this->createMock(GameService::class);
        $gameService->expects(self::once())
            ->method('initialize')
        ;

        $controller = new HomeController($gameService);

        $controller->index();
    }
}
