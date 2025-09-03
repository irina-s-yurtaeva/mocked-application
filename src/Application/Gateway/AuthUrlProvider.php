<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class AuthUrlProvider implements AuthUrlProviderInterface
{
	private const URLS = [
		'ru' => 'https://oauth.bitrix24.tech',
		'by' => 'https://oauth.bitrix24.tech',
		'kz' => 'https://oauth.bitrix24.tech',
		'uz' => 'https://oauth.bitrix24.tech',
		'en' => 'https://oauth.bitrix.info',
	];

	public function __construct(private readonly ?string $baseUrl)
	{
	}

	public function getAuthUrl(): string
	{
		return $this->getUrl();
	}

	public function getRefreshTokenUrl(): string
	{
		return $this->getUrl();
	}

	private function getUrl(): string
	{
		if ($this->baseUrl === null)
		{
			//TODO make routing
			return self::URLS['ru'];
		}

		return $this->baseUrl;
	}
}
