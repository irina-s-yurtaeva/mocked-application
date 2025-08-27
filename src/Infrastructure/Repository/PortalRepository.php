<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Portal;
use App\Domain\Repository\PortalRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PortalRepository implements PortalRepositoryInterface
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Portal::class);
	}

	public function findAll(): array
	{
		return $this->createQueryBuilder('p')
			->orderBy('p.name', 'ASC')
			->getQuery()
			->getResult();
	}
}
