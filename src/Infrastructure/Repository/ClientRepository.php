<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

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

	public function save(Client $client): void
	{
		$this->_em->persist($client);
		$this->_em->flush();
	}

	public function saveClient(
		string $memberId,
		string $domain,
		string $clientEndPoint
	): int {

		if (!($client = $this->findOneByMemberId($memberId)))
		{
			$client = new Client(
				memberId: $memberId,
				domain: $domain,
				clientEndPoint: $clientEndPoint
			);
		}
		else
		{
			$client->setClientEndpoint($clientEndPoint);
			$client->incrementInstallCount();
		}

		$this->_em->persist($client);
		$this->_em->flush();

		return $client->getId();
	}

	public function saveAccessToken(int $clientId, AccessToken $accessToken): int
	{
		/** @var Client|null $client */
		$client = $this->find($clientId);

		if (!$client) {
			throw new \InvalidArgumentException('Client not found');
		}

		$client->setAccessToken($accessToken->getAccessToken());
		$client->setExpiresIn($accessToken->getExpiresIn());
		$client->setApplicationToken($accessToken->getApplicationToken());
		$client->setRefreshToken($accessToken->getRefreshToken());

		$this->_em->persist($client);
		$this->_em->flush();

		return $clientId;
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
}
