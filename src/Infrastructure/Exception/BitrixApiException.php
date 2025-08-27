<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

class BitrixApiException extends \Exception
{
	protected $message = 'Bitrix API error';
}
