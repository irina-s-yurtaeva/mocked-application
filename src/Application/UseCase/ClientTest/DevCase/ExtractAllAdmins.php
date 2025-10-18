<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientTest\DevCase;

use App\Application\Gateway\ApplicationUrlProviderInterface;
use App\Application\Gateway\BitrixApi;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Application\Exception\BitrixApiException;

class ExtractAllAdmins implements DevCaseInterface
{
	private const MAX_USERS_PER_PAGE = 2;
	private const MAX_USERS = 2;
	private mixed $result;

	public function __construct(
		protected ClientRepositoryInterface $clientRepository,
		protected readonly BitrixApi $clientGateway,
		protected readonly ApplicationUrlProviderInterface $applicationUrlProvider,
	) {}

	public function getTitle(): string
	{
		return 'Выбрать и сохранить всех администраторов';
	}

	public function handle(Client $client): void
	{
		$b24Api = $this->clientGateway;
		$handleResult = ['Dev, privet!'];
		if ($accessToken = $this->clientRepository->findLastAdminAccessTokenByMemberId($client->getMemberId()))
		{
			$lastId = 1;
			$eventBindParams = [
				'event' => 'ONAPPTEST',
				'handler' => $this->applicationUrlProvider->getEventHandlerUrl('OnAppTest'),
				'auth_type' => 0,
			];
			$filteredUserId = null;
			$fetchedUsers = [];
			$pages = [];
			do
			{
				if ($lastId === $filteredUserId)
				{
					break;
				}
				$filteredUserId = $lastId;
				$pages[] = [
					'from' => $filteredUserId
				];
				$result = $b24Api->call(
					'user.get',
					$client,
					$accessToken,
					[
						'FILTER' => ['>ID' => $filteredUserId],
						'SORT' => 'ID',
						'ORDER' => 'ASC',
						'ADMIN_MODE' => true,
						'start' => 0,
						'page' => self::MAX_USERS_PER_PAGE,
					]
				);
				foreach ($result as $user)
				{
					try
					{
						$b24Api->call(
							'event.bind',
							$client,
							$accessToken,
							['auth_type' => $user['ID']] + $eventBindParams
						);
					}
					catch (BitrixApiException $exception)
					{

					}
					$fetchedUsers[] = $user['ID'];
					$lastId = $user['ID'];
					if (count($fetchedUsers) >= self::MAX_USERS)
					{
						break 2;
					}
				}

			} while (true);
			$b24Api->call(
				'event.test',
				$client,
				$accessToken,
				[
					'action' => 'saveAdminToken',
				]
			);
			foreach ($fetchedUsers as $userId)
			{
				$b24Api->call(
					'event.unbind',
					$client,
					$accessToken,
					['auth_type' => $userId] + $eventBindParams
				);
			}

			$handleResult = [
				'pages' => $pages,
				'fetched_users' => $fetchedUsers
			];
		}
		$this->result = $handleResult;
	}

	public function getResult(): mixed
	{
		return $this->result;
	}
}
