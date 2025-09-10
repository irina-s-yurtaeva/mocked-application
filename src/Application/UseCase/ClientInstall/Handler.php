<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientInstall;

use App\Application\Gateway\BitrixApi;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use Psr\Log\LoggerInterface;

class Handler
{
	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected BitrixApi $clientGateway,
		protected DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
	) {
	}

	public function __invoke(Request $request): Response
	{
		$client = $this->clientRepository->findOneByApplicationToken($request->client->getApplicationToken())
			?? $this->clientRepository->findOneByMemberId($request->client->getMemberId())
			?? $request->client
		;
		$client
			->setApplicationToken($request->client->getApplicationToken())
			->incrementInstallCount()
			->setClientEndpoint($request->client->getClientEndpoint())
		;

		$savedClient = $this->clientRepository->save($client);

		$this->clientRepository->saveClientAccessToken(
			$savedClient,
			$request->accessToken
		);

		$this->devCaseRunner->run(
			$request,
			$savedClient,
			$request->accessToken,
		);

		return new Response($savedClient->getId());
	}
}
