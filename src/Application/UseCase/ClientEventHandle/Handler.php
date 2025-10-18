<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientEventHandle;

use Psr\Log\LoggerInterface;

class Handler
{
	public function __construct(
		protected DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
	) {
	}

	public function __invoke(Request $request): Response
	{
		$result = $this->devCaseRunner->run(
			$request->client,
			$request->accessToken,
			$request->eventName,
			$request->eventData,
		);

		return new Response($result);
	}
}
