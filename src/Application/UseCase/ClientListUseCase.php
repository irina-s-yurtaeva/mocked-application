<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Repository\ClientRepositoryInterface;

class ClientListUseCase
{
	public function __construct(private ClientRepositoryInterface $repository) {}

	public function __invoke(): array
	{
		return $this->repository->findAll();
	}
}
