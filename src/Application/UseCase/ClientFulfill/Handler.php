<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill;

use App\Application\Gateway\BitrixApi;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Application\Exception\ApplicationIsNotInstalledException;
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
		$client = $this->clientRepository->findOneByMemberId($request->client->getMemberId());
		if (empty($client))
		{
			throw new ApplicationIsNotInstalledException();
		}

		$client->incrementHandleCount();
		$this->clientRepository->save($client);

		$this->logger->info('Client fulfill start', ['clientId' => $client->getId(), 'memberId' => $request->client->getMemberId()]);

		$accessToken = $request->accessToken;

		$result = $this->clientGateway->call('profile', $client, $accessToken);
		?><pre><b>$result: </b><?php print_r($result)?></pre><?php

		$accessToken->setUserData(
			(int)$result['ID'],
			trim($result['NAME'] . ' ' . $result['LAST_NAME']),
			(int)$result['ADMIN'] === 1,
		);

		$this->clientRepository->saveClientAccessToken(
			$client,
			$accessToken
		);

		$this->logger->info('Client profile', ['clientId' => $client->getId(), 'result' => $result]);

		$this->devCaseRunner->run(
			$request,
			$client,
			$request->accessToken,
		);

		return new Response($this->devCaseRunner->getResults());
	}
}
