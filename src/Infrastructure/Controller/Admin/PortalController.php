<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Admin;

use App\Application\UseCase\PortalListUseCase;
use App\Infrastructure\Presentation\TemplateRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class PortalController extends AbstractController
{
	#[Route('/admin/portals/', 'portals', methods: ['GET'])]
	public function getList(
		PortalListUseCase $useCase,
		TemplateRenderer $renderer
	): Response
	{
		$portals = $useCase->execute();
		$content = $renderer->render('portals/list.php', ['portals' => $portals]);

		return new Response($content, 200, ['Content-Type' => 'text/html']);
	}
}
