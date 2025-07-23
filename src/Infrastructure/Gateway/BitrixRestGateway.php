<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure;

use MockedApplication\Application;

class BitrixRestGateway implements Application\BitrixRestGateway
{
	public function __construct(
		private AppSettingsProvider $settingsProvider
	) {}

	public function call(string $method, array $params = []): array
	{
		// Тут — реализация callCurl() в адаптированном виде, без static, без магии
	}
}
