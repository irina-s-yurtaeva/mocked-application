<?php

declare(strict_types=1);

namespace App\Application\Gateway;

abstract class BitrixUrlProvider
{
	abstract public function getEndpointUrl(): string;

	public function getEndpointUrlWithMethod(string $method): string
	{
		return rtrim($this->getEndpointUrl(), '/') . '/' . $method . '.json';
	}
}
