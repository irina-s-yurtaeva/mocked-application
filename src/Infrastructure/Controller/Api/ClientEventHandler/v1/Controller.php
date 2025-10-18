<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientEventHandler\v1;

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
		private readonly LoggerInterface $logger,
	) {
	}

	#[Route('/v1/event/{eventName}', 'client_event_1_get', methods: ['GET', 'HEAD'])]
	public function installGet(string $eventName, Request $request): Response
	{
		return new JsonResponse(['status' => 'success', 'message' => 'Hey, you!'], 200);
	}

	#[Route('/v1/event/{eventName}', 'client_event_1_post', methods: ['POST'])]
	public function handle(string $eventName, Request $request): Response
	{
		try
		{
			$data = $this->manager->handle($eventName, $request);
			return new JsonResponse(['status' => 'success', 'data' => $data], 200);
		}
		catch (\Exception $exception)
		{
			$this->logger->error('Ошибка при событии', [
				'event' => $eventName,
				'request' => $request->request->all(),
				'exception' => $exception,
			]);

			return new JsonResponse(['status' => 'error', 'message' => $exception->getMessage()], 400);
		}
	}
}
