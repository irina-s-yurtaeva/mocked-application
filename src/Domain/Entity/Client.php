<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: 'app_client')]
#[ORM\HasLifecycleCallbacks]
class Client
{
	private const STATUS_FREE = 'F'; // moved from oauth to know about statuses
	private const STATUS_DEMO = 'D'; // moved from oauth to know about statuses
	private const STATUS_TRIAL = 'T'; // moved from oauth to know about statuses
	private const STATUS_PAID = 'P'; // moved from oauth to know about statuses
	private const STATUS_LOCAL = 'L'; // moved from oauth to know about statuses
	private const STATUS_SUBSCRIPTION = 'S'; // moved from oauth to know about statuses

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private ?int $id = null;

	#[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
	private string $memberId;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $applicationToken;

	#[ORM\Column(type: 'string', length: 255, nullable: false)]
	private string $domain;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $clientEndpoint = null;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $scope = null;

	#[ORM\Column(type: 'integer')]
	private int $installCount = 0;

	#[ORM\Column(type: 'integer')]
	private int $handleCount = 0;

	#[ORM\Column(type: 'datetime_immutable')]
	private DateTimeImmutable $createdAt;

	#[ORM\Column(type: 'datetime_immutable')]
	private DateTimeImmutable $updatedAt;

	#[ORM\OneToMany(mappedBy: 'client', targetEntity: AccessToken::class, fetch: 'LAZY')]
	#[ORM\JoinColumn(name: 'id', referencedColumnName: 'client_id', nullable: true)]
	private Collection $accessTokens;

	public function __construct(
		string $memberId,
		string $domain,
		?string $applicationToken,
		?string $scope = null,
		?string $clientEndpoint = null,
	) {
		$this->memberId = $memberId;
		$this->domain = $domain;
		$this->applicationToken = $applicationToken;
		$this->scope = $scope;
		$this->clientEndpoint = $clientEndpoint;
		$this->accessTokens = new ArrayCollection();
	}

	#[ORM\PrePersist]
	public function onPrePersist(): void
	{
		$now = new DateTimeImmutable();
		$this->createdAt = $now;
		$this->updatedAt = $now;
	}

	#[ORM\PreUpdate]
	public function onPreUpdate(): void
	{
		$this->updatedAt = new DateTimeImmutable();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getMemberId(): string
	{
		return $this->memberId;
	}

	public function getDomain(): string
	{
		return $this->domain;
	}

	public function getApplicationToken(): string
	{
		return $this->applicationToken;
	}

	public function getClientEndpoint(): ?string
	{
		return $this->clientEndpoint;
	}

	public function getInstallCount(): int
	{
		return $this->installCount;
	}

	public function getCreatedAt(): DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function getUpdatedAt(): DateTimeImmutable
	{
		return $this->updatedAt;
	}

	public function incrementInstallCount(): self
	{
		$this->installCount++;
		$this->handleCount = 0;

		return $this;
	}

	public function incrementHandleCount(): self
	{
		$this->handleCount++;

		return $this;
	}

	public function setApplicationToken(string $applicationToken): self
	{
		$this->applicationToken = $applicationToken;

		return $this;
	}


	public function setClientEndpoint(?string $clientEndpoint): self
	{
		$this->clientEndpoint = $clientEndpoint;

		return $this;
	}
}
