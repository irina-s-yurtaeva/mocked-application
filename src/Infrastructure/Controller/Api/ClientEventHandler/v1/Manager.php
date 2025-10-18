<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientEventHandler\v1;

use App\Application\UseCase\ClientEventHandle;
use App\Infrastructure\Controller\Api\BaseManager;
use App\Infrastructure\Repository\ClientRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;


class Manager extends BaseManager
{
	public function __construct(
		protected ClientRepository $clientRepository,
		protected ClientEventHandle\Handler $handler,
		protected LoggerInterface $logger,
	)
	{

	}

	public function handle(string $eventName, Request $request): array
	{
		$retrievedClient = $this->retrieveClient($request);
		$client = $this->clientRepository->findOneByApplicationToken($retrievedClient->getApplicationToken())
			?? $this->clientRepository->findOneByMemberId($retrievedClient->getMemberId())
		;
		if (null === $client) {
			throw new \Exception('Client not found');
		}

		return $this->handler->__invoke(
			new ClientEventHandle\Request(
				$client,
				$this->retrieveAccessToken($request),
				$eventName,
				$request->get('data'),
			)
		)->result;
	}
}
