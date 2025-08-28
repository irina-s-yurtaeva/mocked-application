<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use App\Domain\Entity\Client;
use App\Domain\Entity\AccessToken;
use App\Domain\Repository\ClientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Client::class);
	}

	public function saveClient(
		?int $id,
		string $memberId,
		string $domain,
		string $clientEndPoint,
	): int
	{
		$entity = new Client(
			0,
			$memberId,
			$domain,
			$clientEndPoint
		);

		if ($id) {
			$entity->setId($id);
		}

		$this->em->persist($entity);
		$this->em->flush();

		return $entity->getId() ?? 0;
	}

	public function saveAccessToken(
		int $clintId,
		AccessToken $accessToken
	): int
	{
		$entity = $this->em->getRepository(Client::class)->find($clintId);

		if (!$entity) {
			throw new \InvalidArgumentException('Client not found');
		}

		$entity->setAccessToken($accessToken->getAccessToken());
		$entity->setExpiresIn($accessToken->getExpiresIn());
		$entity->setApplicationToken($accessToken->getApplicationToken());
		$entity->setRefreshToken($accessToken->getRefreshToken());

		$this->em->persist($entity);
		$this->em->flush();

		return $clintId;
	}

	public function findAll(): array
	{
		return $this->createQueryBuilder('p')
			->orderBy('p.id', 'ASC')
			->getQuery()
			->getResult();
	}
}
