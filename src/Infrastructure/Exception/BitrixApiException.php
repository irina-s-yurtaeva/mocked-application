<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Exception;

class BitrixApiException extends \Exception
{
	protected $message = 'Bitrix API error';
}
