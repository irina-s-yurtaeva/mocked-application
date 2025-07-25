<?php

declare(strict_types=1);

namespace MockedApplication\Application\Gateway;

abstract class BitrixUrlProvider
{
	abstract public function getAuthenticationUrl(): string;

	abstract public function getEndpointUrl(): string;

	public function getEndpointUrlWithMethod(string $method): string
	{
		return rtrim($this->getEndpointUrl(), '/') . '/' . $method . '.json';
	}
}
