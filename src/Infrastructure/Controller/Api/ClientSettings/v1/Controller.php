<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientSettings\v1;

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

	#[Route('/v1/settings/', 'client_settings_get', methods: ['GET', 'HEAD'])]
	public function settingsGet(Request $request): Response
	{
		return new JsonResponse(['status' => 'success', 'message' => 'Hey, you!'], 200);
	}

	#[Route('/v1/settings/', 'client_settings', methods: ['POST'])]
	public function handle(Request $request): Response
	{
		try
		{
			return new JsonResponse($this->manager->handleGet($request), 200);
		}
		catch (\Exception $exception)
		{
			$this->logger->error('Ошибка получения настроек приложения', ['exception' => $exception]);

			return new JsonResponse(['status' => 'error', 'message' => $exception->getMessage()], 400);
		}
	}

	#[Route('/v1/settings/set/', 'client_settings_set', methods: ['POST'])]
	public function setSettings(Request $request): Response
	{
		return new JsonResponse($this->manager->handleSet($request), 200);
	}
}
