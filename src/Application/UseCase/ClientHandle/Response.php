<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientHandle;

class Response
{
	public function __construct(
		public readonly array $result,
	) {
	}
}
