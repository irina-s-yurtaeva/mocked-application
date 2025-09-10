<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill\DevCase;

use App\Application\Gateway\BitrixApi;
use App\Application\UseCase\ClientFulfill\Request;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

class JustADevCase implements DevCaseInterface
{
	private mixed $result;

	public function __construct(private readonly BitrixApi $clientGateway) {}

	public function handle(Request $request, Client $client, AccessToken $accessToken): void
	{
		$this->result = $this->clientGateway->call('profile', $client, $accessToken);
	}

	public function getResult(): mixed
	{
		return $this->result;
	}
}
