<?php

declare(strict_types=1);

namespace MockedApplication\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'client_settings')]
class ClientSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column]
    private string $memberId;

    #[ORM\Column]
    private string $accessToken;

    #[ORM\Column]
    private string $expiresIn;

    #[ORM\Column]
    private string $applicationToken;

    #[ORM\Column]
    private string $refreshToken;

    #[ORM\Column]
    private string $domain;

    #[ORM\Column]
    private string $clientEndpoint;

    public function __construct(
        string $memberId,
        string $accessToken,
        string $expiresIn,
        string $applicationToken,
        string $refreshToken,
        string $domain,
        string $clientEndpoint
    ) {
        $this->memberId = $memberId;
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->applicationToken = $applicationToken;
        $this->refreshToken = $refreshToken;
        $this->domain = $domain;
        $this->clientEndpoint = $clientEndpoint;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}

