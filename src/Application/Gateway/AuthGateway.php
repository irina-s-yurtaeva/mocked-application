<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Entity\AccessToken;

interface AuthGateway
{
	public function getAccessToken(string $code): AccessToken;

	public function refreshAccessToken(string $refreshToken): AccessToken;
}
