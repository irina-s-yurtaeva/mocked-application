<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientEventHandle\DevCase;

use App\Application\Gateway\BitrixApi;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class DevCaseBase implements DevCaseInterface
{
	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected BitrixApi $clientGateway,
		protected LoggerInterface $logger,
	) {}

	abstract public function run(Client $client, AccessToken $token, mixed $devCaseData = null): array;
}
