<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Admin\List;

use App\Domain\Entity\Client;
use App\Infrastructure\Repository\ClientRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;

class Manager
{
	public function __construct(
		protected ClientRepository $repo,
		protected LoggerInterface $logger,
	)
	{

	}

	/**
	 * @return Client[]
	 */
	public function getPortals(UrlGeneratorInterface $urlGenerator): array
	{
		$portals = $this->repo->findAll();
		foreach ($portals as $portal)
		{
			$portal->urlPath = $urlGenerator->generate('show bitrix24', [
				'memberId' => $portal->getMemberId(),
			]);
		}

		return $portals;
	}
}
