<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Entity\AccessToken;

interface AccessTokenRefresherInterface
{
	public function refresh(AccessToken $token): AccessToken;
}
