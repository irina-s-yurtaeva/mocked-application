<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

interface Transport
{
	public function processRequest(string $url, array $params): array;
	public function processResponse(string $data): array;
}
