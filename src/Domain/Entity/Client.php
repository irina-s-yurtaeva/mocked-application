<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'mocked_app_client')]
#[ORM\UniqueConstraint(name: 'udx_sportsman_user_id', columns: ['user_id'])]
#[ORM\Index(name: 'idx_sportsman_category_code', columns: ['category_code'])]
#[ORM\Index(name: 'idx_sportsman_rank_code', columns: ['rank_code'])]
#[ORM\Index(name: 'idx_sportsman_school_id', columns: ['school_id'])]

class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $memberId;

	#[ORM\Column(type: 'string', length: 255)]
    private string $domain;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $clientEndpoint;

	#[ORM\OneToMany(targetEntity: AccessToken::class, fetch: 'LAZY')]
	#[ORM\JoinColumn(name: 'id', referencedColumnName: 'client_id', nullable: true)]
	private ?AccessToken $accessToken = null;

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
}

