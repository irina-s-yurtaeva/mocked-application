<?php

declare(strict_types=1);

namespace MockedApplication\Application;

interface BitrixRestGateway
{
	/**
	 * @param string $method
	 * @param array $params
	 * @return array<string, mixed>
	 */
	public function call(string $method, array $params = []): array;
}
