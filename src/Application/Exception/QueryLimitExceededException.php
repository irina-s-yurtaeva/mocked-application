<?php

declare(strict_types=1);

namespace App\Application\Exception;

final class QueryLimitExceededException extends BitrixApiException
{
	protected $message = 'Too many requests, maximum 2 query by second';
}
