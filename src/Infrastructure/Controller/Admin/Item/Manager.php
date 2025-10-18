<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Admin\Item;

use App\Application\Gateway\BitrixApiInterface;
use App\Application\UseCase\ClientTest;
use App\Domain\Entity\Client;
use App\Infrastructure\Repository\ClientRepository;
use Psr\Log\LoggerInterface;

class Manager
{
	public function __construct(
		protected ClientRepository $repo,
		protected ClientTest\DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
	)
	{

	}

	public function get(string $memberId): ?Client
	{
		return $this->repo->findOneByMemberId($memberId);
	}

	public function getCases(): array
	{
		return $this->devCaseRunner->getList();
	}

	public function handleTestItem(string $memberId, string $devCaseName): array
	{
		return (new ClientTest\Handler(
			$this->devCaseRunner,
			$this->logger,
		))(
			new ClientTest\Request(
				$this->repo->findOneByMemberId($memberId),
				[$devCaseName],
			)
		)->result;
	}
}
