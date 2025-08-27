<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use \App\Domain\Entity\Portal;

interface PortalRepositoryInterface
{
	/**
	 * @return Portal[]
	 */
	public function findAll(): array;
}
