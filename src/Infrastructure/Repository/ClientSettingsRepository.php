<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Repository;

use MockedApplication\Domain\Repository\ClientSettingsRepositoryInterface;

class ClientSettingsRepository implements ClientSettingsRepositoryInterface
{

	public function saveClientSettings()
	{
		return (boolean)file_put_contents(__DIR__ . '/settings.json', static::wrapData($arSettings));

	}
}
