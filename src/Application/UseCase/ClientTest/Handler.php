<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientTest;

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
		$this->devCaseRunner->run(
			$request->client,
			$request->devCaseNames,
		);

		return new Response($this->devCaseRunner->getResults());
	}
}
