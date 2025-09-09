<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientInstall\DevCase;

use App\Domain\Entity\Client;
use App\Domain\Entity\AccessToken;
use App\Application\UseCase\ClientInstall\Request;
use App\Application\Gateway\BitrixApi;

class BindContactEventsDevCase implements DevCaseInterface
{
	public function __construct(private BitrixApi $clientGateway) {}

	public function handle(Request $request, Client $client, AccessToken $accessToken): void
	{
		$this->clientGateway->call('event.bind', $client, $accessToken, [
			'EVENT' => 'ONCRMCONTACTUPDATE',
			'HANDLER' => $request->handlerUrl,
			'EVENT_TYPE' => 'online'
		]);

		$this->clientGateway->call('event.bind', $client, $accessToken, [
			'EVENT' => 'ONCRMCONTACTADD',
			'HANDLER' => $request->handlerUrl,
			'EVENT_TYPE' => 'online'
		]);
	}
}
