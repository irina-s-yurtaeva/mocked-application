<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Admin\List;

use App\Application\UseCase\ClientListUseCase;
use App\Infrastructure\Presentation\TemplateRenderer;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsController]
class ClientController extends AbstractController
{
	public function __construct(
		private Manager $manager,
		private readonly LoggerInterface $logger,
		private readonly UrlGeneratorInterface $urlGenerator,
	) {
	}

	#[Route('/admin/portals/', 'portals', methods: ['GET'])]
	public function getList(
		TemplateRenderer $renderer
	): Response
	{
		$content = $renderer->render('server/list.php', [
			'portals' => $this->manager->getPortals(
				$this->urlGenerator
			),
		]);

		return new Response($content, 200, ['Content-Type' => 'text/html']);
	}
}
