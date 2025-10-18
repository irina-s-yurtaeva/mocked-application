<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientEventHandle\DevCase;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

class OnAppTest extends DevCaseBase
{
	public function run(Client $client, AccessToken $token, mixed $devCaseData = null): array
	{
		if (!empty($devCaseData['QUERY']['action']))
		{
			$result = $this->clientGateway->call('profile',
				$client,
				$token->setClient($client),
			);
			$this->logger->warning('OnAppTest result', ['result' => $result]);
			if (!empty($result['ADMIN']) && (int)$result['ADMIN'] === 1)
			{
				$token->setUserData(
					(int)$result['ID'],
					trim($result['NAME'] . ' ' . $result['LAST_NAME']),
					true,
				);
				$this->clientRepository->saveClientAccessToken(
					$client,
					$token
				);
			}
		}

		return [];
	}
}
