<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\ClientInstallRequest;
use App\Application\UseCase\Response\ClientInstallResponse;
use App\Application\Gateway\BitrixRestGateway;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;

class ClientInstall
{
	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected BitrixRestGateway $gateway,
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

		return new ClientInstallResponse($client->getId());

		$this->clientRepository->saveAccessToken(
			$client->getId(),
			$this->gateway->getAccessToken(
				$request->memberId,
				$request->domain,
				$request->clientEndpoint,
				$request->accessToken,
				$request->expiresIn,
				$request->applicationToken,
				$request->refreshToken
			)
		);



		$this->gateway->call(
			'event.bind',
			[
				'EVENT' => 'ONCRMCONTACTUPDATE',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);

		$this->gateway->call(
			'event.bind',
			[
				'EVENT' => 'ONCRMCONTACTADD',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);

	}
}
