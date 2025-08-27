<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Repository\PortalRepositoryInterface;

class PortalListUseCase
{
	public function __construct(private PortalRepositoryInterface $repository) {}

	public function execute(): array
	{
		return [];
		return $this->repository->findAll();
	}
}
