<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientEventHandle;

use App\Application\Gateway\BitrixApi;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use Psr\Log\LoggerInterface;

class DevCaseRunner
{
	public function __construct(
		protected ClientRepositoryInterface $repository,
		protected BitrixApi $clientGateway,
		protected LoggerInterface $logger,
	) {}

	public function run(Client $client, AccessToken $token, string $devCaseName, mixed $devCaseData = null): array
	{
		return $this->get($devCaseName)->run($client, $token, $devCaseData);
	}

	public function get(string $devCaseName): DevCase\DevCaseInterface
	{
		$devCaseName = __NAMESPACE__ . '\\DevCase\\' . ucfirst($devCaseName);
		if (class_exists($devCaseName))
		{
			return new $devCaseName(
				$this->repository,
				$this->clientGateway,
				$this->logger,
			);
		}

		return (new class implements DevCase\DevCaseInterface {
			public function run(Client $client, AccessToken $token, mixed $devCaseData = null): array
			{
				return ['error' => 'Case not found'];
			}
		});
	}
}
