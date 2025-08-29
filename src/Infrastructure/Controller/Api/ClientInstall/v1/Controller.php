<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientInstall\v1;

use App\Application\UseCase\ClientInstall;
use App\Application\UseCase\Request\ClientInstallRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;

#[AsController]
class Controller extends AbstractController
{
	public function __construct(
		private readonly LoggerInterface $logger
	) {
	}

	#[Route('/v1/install/', 'client_install', methods: ['POST'])]
	public function install(
		ClientInstall $useCase,
		ClientInstallRequest $request,
	): JsonResponse
	{
		$this->logger->debug('Привет! Это лог из контроллера установки клиента.');
		$answer = $useCase($request);

		return new JsonResponse($answer);
	}

	#[Route('/v1/install/', 'client_install_test', methods: ['GET'])]
	public function installTest(): JsonResponse
	{
		$this->logger->debug('Привет! Это test лог из контроллера установки клиента.');
		return new JsonResponse(['status' => 'ok']);
	}
}
