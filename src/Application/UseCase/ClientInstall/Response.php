<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientInstall;

class Response
{
	public function __construct(
		public readonly int $id,
	) {
	}
}
