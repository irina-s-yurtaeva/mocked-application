<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Exception;

final class MethodNotFoundException extends BitrixApiException
{
	protected $message = 'Method not found! You can see the permissions of the application: CRest::call(scope)';
}
