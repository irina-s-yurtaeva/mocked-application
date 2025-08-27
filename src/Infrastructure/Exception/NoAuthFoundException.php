<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

final class NoAuthFoundException extends BitrixApiException
{
	protected $message = 'Some setup error b24, check in table "b_module_to_module" event "OnRestCheckAuth"';
}
