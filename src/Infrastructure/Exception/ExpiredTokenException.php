<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

final class ExpiredTokenException extends BitrixApiException
{
	protected $message = 'expired token, cant get new auth? Check access oauth server.';
}
