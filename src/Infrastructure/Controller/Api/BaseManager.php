<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api;

use App\Application\Exception\BitrixApiException;
use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;
use Symfony\Component\HttpFoundation\Request;

class BaseManager
{
	protected function retrieveClient(Request $request): Client
	{
		if (!empty($request->get('auth')))
		{
			return new Client(
				memberId: $request->get('auth')['member_id'],
				domain: $request->get('auth')['domain'],
				applicationToken: $request->get('auth')['application_token'],
				scope: $request->get('auth')['scope'] ?? null,
				clientEndpoint: $request->get('auth')['client_endpoint'],
			);
		}
		else if ($request->get('DOMAIN'))
		{
			return new Client(
				memberId: $request->get('member_id'),
				domain: ($request->get('DOMAIN')),
				applicationToken: null,
				scope: null,
				clientEndpoint: 'https://' . $request->get('DOMAIN') . '/rest/',
			);
		}

		throw new BitrixApiException('Invalid request parameters for the client params.');
	}

	protected function retrieveAccessToken(Request $request): AccessToken
	{
		if (!empty($request->get('auth')))
		{
			return new AccessToken(
				id: 0,
				clientId: 0,
				accessToken: $request->get('auth')['access_token'],
				expiresIn: (new \DateTimeImmutable())->setTimestamp((int)$request->get('auth')['expires']),
				refreshToken: $request->get('auth')['refresh_token'],
				serverEndPoint: $request->get('auth')['server_endpoint'] ?? null,
				userId: (int) $request->get('auth')['user_id'] ?? null,
				userFullName: $request->get('auth')['user_full_name'] ?? null,
			);
		}
		else if ($request->get('DOMAIN'))
		{
			return new AccessToken(
				id: 0,
				clientId: 0,
				accessToken: ($request->get('AUTH_ID')),
				expiresIn: (new \DateTimeImmutable())->setTimestamp(time() + (int)$request->get('AUTH_EXPIRES')),
				refreshToken: ($request->get('REFRESH_ID')),
				serverEndPoint: $request->get('SERVER_ENDPOINT') ?? null,
				userId: null,
				userFullName: null,
			);
		}

		throw new BitrixApiException('Invalid request parameters for the access token.');
	}
}
