<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class BitrixUrlGenerator
{
	public function getEndpointUrlWithMethod(string $domain, string $method): string
	{
		return rtrim($domain, '/') . '/' . $method . '.json';
	}
}
