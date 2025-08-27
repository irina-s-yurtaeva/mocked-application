<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM;

#[ORM\Entity]
#[ORM\Table(name: 'mocked_app_access_token')]
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
    private string $applicationToken;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $refreshToken;

	#[ORM\Column(type: 'integer', nullable: true)]
	private ?int $userId;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $userFullName;

	#[ORM\ManyToOne(targetEntity: Client::class, fetch: 'LAZY')]
	#[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', nullable: false)]
	private ?Client $client = null;

	/**
	 * AccessToken constructor.
	 */

	public function __construct(
		int $id,
		int $clientId,
		string $accessToken,
		\DateTimeImmutable $expiresIn,
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

