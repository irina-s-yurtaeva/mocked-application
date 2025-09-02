<?php

declare(strict_types=1);

namespace App\Application\Exception;

final class InvalidClientException extends BitrixApiException
{
	protected $message = 'invalid client, check out define C_REST_CLIENT_SECRET or C_REST_CLIENT_ID';
}
