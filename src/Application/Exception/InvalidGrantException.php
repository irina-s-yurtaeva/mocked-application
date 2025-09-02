<?php

declare(strict_types=1);

namespace App\Application\Exception;

final class InvalidGrantException extends BitrixApiException
{
	protected $message = 'invalid grant, check out define C_REST_CLIENT_SECRET or C_REST_CLIENT_ID';
}
