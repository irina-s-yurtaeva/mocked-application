<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientInstall\DevCase;

use App\Domain\Entity\Client;
use App\Domain\Entity\AccessToken;
use App\Application\UseCase\ClientInstall\Request;

interface DevCaseInterface
{
	public function handle(Request $request, Client $client, AccessToken $accessToken): void;
}
