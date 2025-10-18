<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientEventHandle\DevCase;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

interface DevCaseInterface
{
	public function run(Client $client, AccessToken $token, mixed $devCaseData = null): array;
}
