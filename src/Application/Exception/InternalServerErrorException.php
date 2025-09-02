<?php

declare(strict_types=1);

namespace App\Application\Exception;

final class InternalServerErrorException extends BitrixApiException
{
	protected $message = 'Internal Server Error. Try later';
}
