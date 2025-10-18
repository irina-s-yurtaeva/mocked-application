<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Client;
use App\Domain\Entity\AccessToken;
use App\Domain\Repository\ClientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
	public function __construct(
		ManagerRegistry $registry,
		protected LoggerInterface $logger
	)
	{
		parent::__construct($registry, Client::class);
	}

	public function save(Client $client): Client
	{
		$this->getEntityManager()->persist($client);
		$this->getEntityManager()->flush();

		return $this->findOneByApplicationToken($client->getApplicationToken());
	}

	public function saveClientAccessToken(Client $client, AccessToken $accessToken): void
	{
		if ($client->getId() !== null && $accessToken->getUserId() !== null)
		{
			$existingToken = $this->createQueryBuilder('c')
				->innerJoin(AccessToken::class, 'at', 'WITH', 'at.client = c.id')
				->andWhere('at.clientId = :clientId')
				->setParameter('clientId', $client->getId())
				->andWhere('at.userId = :userId')
				->setParameter('userId', $accessToken->getUserId())
				->orderBy('at.expiresIn', 'DESC')
				->setMaxResults(1)
				->select('at')
				->getQuery()
				->getOneOrNullResult();

			if ($existingToken) {
				$existingToken->setAccessToken($accessToken->getAccessToken());
				$existingToken->setRefreshToken($accessToken->getRefreshToken());
				$existingToken->setExpiresIn($accessToken->getExpiresIn());
				$existingToken->setServerEndPoint($accessToken->getServerEndPoint());

				$existingToken->setUserData(
					(int)$existingToken->getUserId(),
					$accessToken->getFullName() ?? $existingToken->getFullName(),
					$accessToken->isAdmin() ?? $existingToken->isAdmin() ?? false
				);

				$accessToken = $existingToken;
			}
		}
		$accessToken->setClient($client);
		$this->getEntityManager()->persist($accessToken);
		$this->getEntityManager()->flush();
	}

	public function saveAccessToken(AccessToken $accessToken): void
	{
		$this->getEntityManager()->persist($accessToken);
		$this->getEntityManager()->flush();
	}

	/**
	 * @return Client[]
	 */
	public function findAll(): array
	{
		return $this->createQueryBuilder('c')
			->orderBy('c.id', 'ASC')
			->getQuery()
			->getResult();
	}

	public function findOneByMemberId(string $memberId): ?Client
	{
		return $this->createQueryBuilder('c')
			->where('c.memberId = :memberId')
			->setParameter('memberId', $memberId)
			->getQuery()
			->getOneOrNullResult();
	}

	public function findOneByApplicationToken(string $applicationToken): ?Client
	{
		return $this->createQueryBuilder('c')
			->where('c.applicationToken = :applicationToken')
			->setParameter('applicationToken', $applicationToken)
			->getQuery()
			->getOneOrNullResult();
	}

	public function findLastAdminAccessTokenByMemberId(string $memberId): ?AccessToken
	{
		$result = $this->createQueryBuilder('c')
			->innerJoin(AccessToken::class, 'at', 'WITH', 'at.client = c.id')
			->andWhere('c.memberId = :memberId')
			->andWhere('at.isAdmin = :isAdmin')
			->setParameter('memberId', $memberId)
			->setParameter('isAdmin', true)
			->orderBy('at.expiresIn', 'DESC')  // or createdAt if you add it later
			->setMaxResults(1)
			->select('at')
			->getQuery()
			->getOneOrNullResult();

		return $result instanceof AccessToken ? $result : null;
	}
}
