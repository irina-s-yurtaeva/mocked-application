<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface AuthUrlProviderInterface
{
	public function getAuthUrl(): string;

	public function getRefreshTokenUrl(): string;
}
