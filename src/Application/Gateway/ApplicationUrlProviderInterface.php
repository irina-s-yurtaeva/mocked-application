<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface ApplicationUrlProviderInterface
{
	public function getEventHandlerUrl(string $eventName): string;
}
