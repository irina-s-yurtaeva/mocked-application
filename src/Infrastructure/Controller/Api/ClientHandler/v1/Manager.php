<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientHandler\v1;

use App\Application\Exception\BitrixApiException;
use App\Application\Gateway\BitrixApiInterface;
use App\Application\UseCase\ClientFulfill;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use App\Infrastructure\Repository\ClientRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class Manager
{
	public function __construct(
		protected ClientRepository $repo,
		protected BitrixApiInterface $bitrixApi,
		protected ClientFulfill\DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
	)
	{

	}

	public function handle(Request $request): void
	{
		if (!empty($request->get('auth')))
		{
			$useCaseRequest = $this->formRequestForAnApp($request);
		}
		else if ($request->get('DOMAIN'))
		{
			$useCaseRequest = $this->formRequestForAPlacement($request);
		}
		else
		{
			throw new BitrixApiException(
				'Invalid request parameters for application installation.',
			);
		}

		(new ClientFulfill\Handler(
			$this->repo,
			$this->bitrixApi,
			$this->devCaseRunner,
			$this->logger,
		))($useCaseRequest);
	}

	private function formRequestForAnApp(Request $request): ClientFulfill\Request
	{
		return new ClientFulfill\Request(
			new Client(
				memberId: $request->get('auth')['member_id'],
				domain: $request->get('auth')['domain'],
				applicationToken: $request->get('auth')['application_token'],
				scope: $request->get('auth')['scope'] ?? null,
				clientEndpoint: $request->get('auth')['client_endpoint'],
			),
			accessToken: new AccessToken(
				id: 0,
				clientId: 0,
				accessToken: $request->get('auth')['access_token'],
				expiresIn: (new \DateTimeImmutable())->setTimestamp((int)$request->get('auth')['expires']),
				refreshToken: $request->get('auth')['refresh_token'],
				serverEndPoint: $request->get('auth')['server_endpoint'] ?? null,
				userId: (int) $request->get('auth')['user_id'] ?? null,
				userFullName: $request->get('auth')['user_full_name'] ?? null,
			)
		);
	}

	private function formRequestForAPlacement(Request $request): ClientFulfill\Request
	{
		return new ClientFulfill\Request(
			new Client(
				memberId: $request->get('member_id'),
				domain: ($request->get('DOMAIN')),
				applicationToken: null,
				scope: null,
				clientEndpoint: 'https://' . $request->get('DOMAIN') . '/rest/',
			),
			accessToken: new AccessToken(
				id: 0,
				clientId: 0,
				accessToken: ($request->get('AUTH_ID')),
				expiresIn: (new \DateTimeImmutable())->setTimestamp((int)$request->get('AUTH_EXPIRES')),
				refreshToken: ($request->get('REFRESH_ID')),
				serverEndPoint: null,
				userId: null,
				userFullName: null,
			)
		);
	}
}
