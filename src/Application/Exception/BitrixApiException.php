<?php

declare(strict_types=1);

namespace App\Application\Exception;

class BitrixApiException extends \Exception
{
	protected $message = 'Bitrix API error';
}
