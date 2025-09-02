<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Entity\Client;

#[ORM\Entity]
#[ORM\Table(name: 'app_client_access_token')]
class AccessToken
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(type: 'integer')]
	private int $clientId;

	#[ORM\Column(type: 'string', length: 255)]
	private string $accessToken;

	#[ORM\Column(type: 'datetime_immutable', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
	private \DateTimeImmutable $expiresIn;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $applicationToken = null;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $refreshToken = null;

	#[ORM\Column(type: 'integer', nullable: true)]
	private ?int $userId = null;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $userFullName = null;

	#[ORM\ManyToOne(targetEntity: Client::class, fetch: 'LAZY', inversedBy: 'accessTokens')]
	#[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', nullable: false)]
	private ?Client $client = null;

	public function __construct(
		int $id,
		int $clientId,
		string $accessToken,
		\DateTimeImmutable $expiresIn,
		?string $applicationToken,
		?string $refreshToken,
		?int $userId,
		?string $userFullName
	) {
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

	public function getClientId(): int
	{
		return $this->clientId;
	}

	public function getAccessToken(): string
	{
		return $this->accessToken;
	}

	public function getRefreshToken(): ?string
	{
		return $this->refreshToken;
	}
}
