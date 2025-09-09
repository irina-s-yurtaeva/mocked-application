<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use Symfony\Component\Validator\Constraints as Assert;

class Request
{
	public function __construct(
		#[Assert\NotNull]
		public readonly Client $client,
		#[Assert\NotNull]
		public readonly AccessToken $accessToken,
	)
	{
	}
}
