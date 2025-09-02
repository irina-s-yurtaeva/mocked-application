<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use App\Domain\Entity\AccessToken;
use Symfony\Component\Validator\Constraints as Assert;

class ClientInstallRequest
{
    public function __construct(
	    #[Assert\NotBlank(message: "memberId is required")]
	    #[Assert\Length(min: 3, max: 255)]
		public readonly string $memberId,
	    #[Assert\NotBlank]
	    #[Assert\Url]
		public readonly string $domain,
	    #[Assert\Length(max: 255)]
		public readonly string $clientEndpoint,
	    #[Assert\NotNull]
		public readonly string $handlerUrl,
	    #[Assert\NotNull]
		public readonly AccessToken $accessToken,
	)
	{
	}
}
