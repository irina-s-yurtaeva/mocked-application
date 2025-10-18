<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientStub;

use App\Infrastructure\Controller\Api\ClientInstall\v1\Manager;
use App\Infrastructure\Presentation\TemplateRenderer;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller extends AbstractController
{
	public function __construct(
		private Manager $manager,
		private TemplateRenderer $renderer,
		private readonly LoggerInterface $logger,
	) {
	}

	#[Route('/v1/demo/', 'client_demo', methods: ['GET', 'HEAD'])]
	public function demo(Request $request): Response
	{
		return new JsonResponse(['status' => 'success', 'message' => 'Hey, you! demo'], 200);
	}

	#[Route('/v1/feedback/', 'client_feedback', methods: ['GET', 'HEAD'])]
	public function feedback(Request $request): Response
	{
		return new JsonResponse(['status' => 'success', 'message' => 'Hey, you! feedback'], 200);
	}

	#[Route('/v1/license/', 'client_license', methods: ['GET', 'HEAD'])]
	public function license(Request $request): Response
	{
		return new JsonResponse(['status' => 'success', 'message' => 'Hey, you! license'], 200);
	}

	#[Route('/v1/privatepolicy/', 'client_privatepolicy', methods: ['GET', 'HEAD'])]
	public function privatepolicy(Request $request): Response
	{
		return new JsonResponse(['status' => 'success', 'message' => 'Hey, you! privatepolicy'], 200);
	}
}
