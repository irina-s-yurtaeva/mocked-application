<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'app_client')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
    private string $memberId;

	#[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $domain;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $clientEndpoint;

	#[ORM\JoinColumn(name: 'id', referencedColumnName: 'client_id', nullable: true)]
	#[ORM\OneToMany(mappedBy: 'client', targetEntity: AccessToken::class, fetch: 'LAZY')]
	private Collection $accessTokens;

	public function __construct(
		?int $id = null,
        string $memberId,
        string $domain,
        string $clientEndpoint
    ) {
		$this->id = $id;
        $this->memberId = $memberId;
        $this->domain = $domain;
        $this->clientEndpoint = $clientEndpoint;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

	public function getName(): string
	{
		return $this->domain;
	}

	public function getUrl(): string
	{
		return $this->clientEndpoint;
	}
}
