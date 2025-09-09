<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill;

class Response
{
	public function __construct(
		public readonly array $result,
	) {
	}
}
