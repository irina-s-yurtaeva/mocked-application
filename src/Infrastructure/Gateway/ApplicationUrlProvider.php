<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\ApplicationUrlProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ApplicationUrlProvider implements ApplicationUrlProviderInterface
{
	public function __construct(
		protected RequestStack $requestStack
	) {
	}

	public function getEventHandlerUrl(string $eventName): string
	{
		$request = $this->requestStack->getMainRequest();

		if (!$request) {
			return 'https://localhost/v1/event/' . urlencode($eventName);
		}

		$scheme = $request->getScheme();
		$host = $request->getHost();
		$port = $request->getPort();
		$portPart = in_array($port, [80, 443]) ? '' : ":$port";

		return "{$scheme}://{$host}{$portPart}/v1/event/" . urlencode($eventName);
	}
}
