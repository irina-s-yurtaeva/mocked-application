<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill;

use App\Application\Gateway\BitrixApi;
use App\Domain\Repository\ClientRepositoryInterface;
use Psr\Log\LoggerInterface;

class Handler
{
	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected BitrixApi $clientGateway,
		protected DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,

	) {
	}

	public function __invoke(Request $request): Response
	{
		$client = $request->client;
//		$client->incrementHandleCount();
//		$client->save();

		$this->devCaseRunner->run(
			$request,
			$client,
			$request->accessToken,
		);

		return new Response($this->devCaseRunner->getResults());
	}
}
