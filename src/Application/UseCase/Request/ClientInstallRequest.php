<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use Symfony\Component\Validator\Constraints as Assert;

class ClientInstallRequest
{
	public function __construct(
		#[Assert\NotNull]
		public readonly Client $client,
		#[Assert\NotNull]
		public readonly string $handlerUrl,
		#[Assert\NotNull]
		public readonly AccessToken $accessToken,
	)
	{
	}
}
