<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\ClientInstallRequest;
use App\Application\UseCase\Response\ClientInstallResponse;
use App\Application\Gateway\BitrixApi;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;

class ClientInstall
{
	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected BitrixApi $clientGateway,
	) {
	}

	public function __invoke(ClientInstallRequest $request): ClientInstallResponse
	{
		$client = $this->clientRepository->findOneByMemberId($request->memberId);

		if (!$client)
		{
			$client = new Client(
				memberId: $request->memberId,
				domain: $request->domain,
				clientEndPoint: $request->clientEndpoint
			);
		}

		$client->incrementInstallCount();

		$this->clientRepository->save($client);

		$this->clientRepository->saveAccessToken(
			$client->getId(),
			$request->accessToken
		);

		$this->makeSomeAfterInstallation($request, $request->accessToken);

		return new ClientInstallResponse($client->getId());
	}

	private function makeSomeAfterInstallation(ClientInstallRequest $request, AccessToken $accessToken): void
	{
		return;
		//TODO make some client scenarios
		//TODO Make some Vostrikovs scenario after installation
		$this->clientGateway->call(
			'event.bind',
			$accessToken,
			[
				'EVENT' => 'ONCRMCONTACTUPDATE',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);

		$this->clientGateway->call(
			'event.bind',
			$accessToken,
			[
				'EVENT' => 'ONCRMCONTACTADD',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);
	}
}
