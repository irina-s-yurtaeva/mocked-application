<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use MockedApplication\Domain\Entity\ClientSetting;
use MockedApplication\Domain\Repository\ClientSettingsRepositoryInterface;

class ClientSettingsRepository implements ClientSettingsRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function saveClientSettings(
        string $memberId,
        string $accessToken,
        string $expiresIn,
        string $applicationToken,
        string $refreshToken,
        string $domain,
        string $clientEndpoint
    ): int {
        $entity = new ClientSetting(
            $memberId,
            $accessToken,
            $expiresIn,
            $applicationToken,
            $refreshToken,
            $domain,
            $clientEndpoint
        );

        $this->em->persist($entity);
        $this->em->flush();

        return $entity->getId() ?? 0;
    }
}
