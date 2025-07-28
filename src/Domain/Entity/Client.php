<?php

declare(strict_types=1);

namespace MockedApplication\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'mocked_app_client')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column]
    private string $memberId;

    #[ORM\Column]
    private string $domain;

    #[ORM\Column]
    private string $clientEndpoint;

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

