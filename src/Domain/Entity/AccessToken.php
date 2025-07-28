<?php

declare(strict_types=1);

namespace src\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'mocked_app_access_token')]
class AccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column]
    private int $clientId;

    #[ORM\Column]
    private string $accessToken;

    #[ORM\Column]
    private string $expiresIn;

    #[ORM\Column]
    private string $applicationToken;

    #[ORM\Column]
    private string $refreshToken;

	#[ORM\Column]
	private ?int $userId;

	#[ORM\Column]
	private ?string $userFullName;


	/**
	 * AccessToken constructor.
	 */

	public function __construct(
		?int   $id,
		int $clientId,
		string $accessToken,
		string $expiresIn,
		string $applicationToken,
		string $refreshToken,
		?int $userId,
		?int $userFullName
	)
	{
		$this->id = $id;
		$this->clientId = $clientId;
		$this->accessToken = $accessToken;
		$this->expiresIn = $expiresIn;
		$this->applicationToken = $applicationToken;
		$this->refreshToken = $refreshToken;
		$this->userId = $userId;
		$this->userFullName = $userFullName;
	}

	public function getId(): ?int
	{
		return $this->id;
	}
}

