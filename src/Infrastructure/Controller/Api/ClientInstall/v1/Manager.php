<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientInstall\v1;

use App\Application\Exception\BitrixApiException;
use App\Application\Gateway\BitrixApi;
use App\Application\UseCase\ClientInstall;
use App\Application\UseCase\Request\ClientInstallRequest;
use App\Domain\Entity\AccessToken;
use App\Infrastructure\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;

class Manager
{
	private const INSTALL_AS_A_PLACEMENT = 'placement';
	private const INSTALL_AS_AN_APPLICATION = 'application';

	private ?string $installType = null;

	public function __construct(
		protected ClientRepository $repo,
		protected BitrixApi $bitrixApi,
	)
	{

	}

	public function isHTMLAnswer(): bool
	{
		return $this->installType === self::INSTALL_AS_A_PLACEMENT;
	}

	public function install(Request $request): void
	{
		$this->installType = null;

		if ($request->get('event') === 'ONAPPINSTALL' && !empty($request->get('auth')))
		{
			$this->installType = self::INSTALL_AS_AN_APPLICATION;
			$useCaseRequest = $this->formRequestForAnApp($request);
		}
		else if ($request->get('PLACEMENT') === 'DEFAULT')
		{
			$this->installType = self::INSTALL_AS_A_PLACEMENT;
			$useCaseRequest = $this->formRequestForAPlacement($request);
		}
		else
		{
			throw new BitrixApiException(
				'Invalid request parameters for application installation.',
			);
		}

		(new ClientInstall(
			$this->repo,
			$this->bitrixApi,
		))($useCaseRequest);
	}

	private function formRequestForAnApp(Request $request): ClientInstallRequest
	{
		return new ClientInstallRequest(
			memberId: $request->get('auth')['member_id'],
			domain: $request->get('auth')['domain'],
			clientEndpoint: $request->get('auth')['client_endpoint'],
			handlerUrl: $request->getRequestUri(),
			accessToken: new AccessToken(
				id: 0,
				clientId: 0,
				accessToken: $request->get('auth')['access_token'],
				expiresIn: (new \DateTimeImmutable())->setTimestamp((int)$request->get('auth')['expires_in']),
				applicationToken: $request->get('auth')['application_token'],
				refreshToken: $request->get('auth')['refresh_token'],
				userId: $request->get('auth')['user_id'] ?? null,
				userFullName: $request->get('auth')['user_full_name'] ?? null,
			)
		);
	}

	private function formRequestForAPlacement(Request $request): ClientInstallRequest
	{
		return new ClientInstallRequest(
			memberId: $request->get('member_id'),
			domain: ($request->get('DOMAIN')),
			clientEndpoint: 'https://' . $request->get('DOMAIN') . '/rest/',
			handlerUrl: $request->getRequestUri(),
			accessToken: new AccessToken(
				id: 0,
				clientId: 0,
				accessToken: ($request->get('AUTH_ID')),
				expiresIn: (new \DateTimeImmutable())->setTimestamp((int)$request->get('AUTH_EXPIRES')),
				applicationToken: ($request->get('APP_SID')),
				refreshToken: ($request->get('REFRESH_ID')),
				userId: null,
				userFullName: null,
			)
		);
	}
}
