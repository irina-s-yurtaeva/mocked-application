<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use MockedApplication\Domain\Entity\Client;
use MockedApplication\Domain\Repository\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Connection $connection
    ) {
    }

    public function saveClient(
        string $memberId,
        string $accessToken,
        string $expiresIn,
        string $applicationToken,
        string $refreshToken,
        string $domain,
        string $clientEndpoint
    ): int {
        $entity = new Client(
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
