<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientHandler\v1;

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

	#[Route('/v1/handler/', 'client_fulfill', methods: ['POST'])]
	public function handle(Request $request): Response
	{
		try
		{
			$this->logger->info('Handle request', ['request' => $request->request->all()]);

			$this->manager->handle($request);

			$content = $this->renderer->render('client/handle_succeeded.php', []);

			return new Response($content, 200, ['Content-Type' => 'text/html']);
		}
		catch (\Exception $exception)
		{
			$this->logger->error('Ошибка отрисовки приложения', ['exception' => $exception]);

			return new JsonResponse(['status' => 'error', 'message' => $exception->getMessage()], 400);
		}
	}

	#[Route('/v1/handler/', 'client_fulfill', methods: ['GET'])]
	public function handleGet(): JsonResponse
	{
		return new JsonResponse(['status' => 'ok']);
	}
}
