<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Exception;

final class InternalServerErrorException extends BitrixApiException
{
	protected $message = 'Internal Server Error. Try later';
}
