<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientInstall\v1;

use App\Infrastructure\Presentation\TemplateRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class Controller extends AbstractController
{
	public function __construct(
		private Manager $manager,
		private TemplateRenderer $renderer,
		private readonly LoggerInterface $logger,
	) {
	}

	#[Route('/v1/install/', 'client_install', methods: ['POST'])]
	public function install(Request $request): Response
	{
		try
		{
			$this->logger->info('Install request', ['request' => $request->request->all()]);
			$this->manager->install($request);

			if ($this->manager->isHTMLAnswer())
			{
				$content = $this->renderer->render('client/install_succeeded.php', []);

				return new Response($content, 200, ['Content-Type' => 'text/html']);
			}

			return new JsonResponse(['status' => 'ok']);
		}
		catch (\Exception $exception)
		{
			$this->logger->error('Ошибка установки приложения', ['exception' => $exception]);
			if ($this->manager->isHTMLAnswer())
			{
				$content = $this->renderer->render('client/install_failed.php', []);

				return new Response($content, 200, ['Content-Type' => 'text/html']);
			}

			return new JsonResponse(['status' => 'error', 'message' => $exception->getMessage()], 400);
		}
	}

	#[Route('/v1/install/test/', 'client_install_test', methods: ['GET'])]
	public function installTest(): JsonResponse
	{
		return new JsonResponse(['status' => 'ok']);
	}
}
