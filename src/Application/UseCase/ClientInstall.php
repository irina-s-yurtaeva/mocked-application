<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\ClientInstallRequest;
use App\Application\UseCase\Response\ClientInstallResponse;
use App\Application\Gateway\BitrixApi;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use Psr\Log\LoggerInterface;

class ClientInstall
{
	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected BitrixApi $clientGateway,
		protected LoggerInterface $logger,
	) {
	}

	public function __invoke(ClientInstallRequest $request): ClientInstallResponse
	{
		$client = $request->client;
		$client->incrementInstallCount();

		$savedClient = $this->clientRepository->save($client);

		$this->clientRepository->saveClientAccessToken(
			$savedClient,
			$request->accessToken
		);

		$this->makeSomeAfterInstallation(
			$request,
			$savedClient,
			$request->accessToken
		);

		return new ClientInstallResponse($savedClient->getId());
	}

	private function makeSomeAfterInstallation(
		ClientInstallRequest $request,
		Client $client,
		AccessToken $accessToken): void
	{
		return;
		//TODO make some client scenarios
		//TODO Make some Vostrikovs scenario after installation
		$this->clientGateway->call(
			'event.bind',
			$client,
			$accessToken,
			[
				'EVENT' => 'ONCRMCONTACTUPDATE',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);

		$this->clientGateway->call(
			'event.bind',
			$client,
			$accessToken,
			[
				'EVENT' => 'ONCRMCONTACTADD',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);
	}
}
