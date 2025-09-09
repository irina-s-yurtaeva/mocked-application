<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill\DevCase;

use App\Application\UseCase\ClientFulfill\Request;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

interface DevCaseInterface
{
	public function handle(Request $request, Client $client, AccessToken $accessToken): void;
	public function getResult(): mixed;
}
