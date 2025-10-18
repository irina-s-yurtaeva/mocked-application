<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Admin\Item;

use App\Infrastructure\Presentation\TemplateRenderer;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class ClientController extends AbstractController
{
	public function __construct(
		private Manager $manager,
		private readonly LoggerInterface $logger,
	) {
	}

	#[Route('/admin/portal/{memberId}/', 'show bitrix24', methods: ['GET'])]
	public function getItem(
		string $memberId,
		TemplateRenderer $renderer
	): Response
	{
		$portal = $this->manager->get($memberId);

		$content = $renderer->render('server/item.php', [
			'portal' => $portal,
			'devCases' => $this->manager->getCases(),
		]);

		return new Response($content, 200, ['Content-Type' => 'text/html']);
	}

	#[Route('/admin/test/{memberId}/{devCaseName}', 'test bitrix24', methods: ['GET'])]
	public function testItem(string $memberId, string $devCaseName, TemplateRenderer $renderer): Response
	{
		$result = $this->manager->handleTestItem($memberId, $devCaseName);

		$content = $renderer->render('server/itemTest.php', [
			'portal' => $this->manager->get($memberId),
			'result' => $result,
			'devCaseName' => $devCaseName,
			'devCases' => $this->manager->getCases(),
		]);

		return new Response($content, 200, ['Content-Type' => 'text/html']);
	}
}
