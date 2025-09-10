<?php

declare(strict_types=1);

namespace App\Application\Exception;

class ApplicationIsNotInstalledException extends BitrixApiException
{
	protected $message = 'Application is not installed. Please install the application in your Bitrix24 account.';
}
