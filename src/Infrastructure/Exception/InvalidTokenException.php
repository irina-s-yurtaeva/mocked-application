<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

final class InvalidTokenException extends BitrixApiException
{
	protected $message = 'invalid token, need reinstall application';
}
