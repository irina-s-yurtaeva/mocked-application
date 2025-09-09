<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientInstall\v1;

use App\Application\Exception\BitrixApiException;
use App\Application\Gateway\BitrixApiInterface;
use App\Application\UseCase\ClientInstall;
use App\Infrastructure\Controller\Api\BaseManager;
use App\Infrastructure\Repository\ClientRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class Manager extends BaseManager
{
	private const INSTALL_AS_A_PLACEMENT = 'placement';
	private const INSTALL_AS_AN_APPLICATION = 'application';

	private ?string $installType = null;

	public function __construct(
		protected ClientRepository $repo,
		protected BitrixApiInterface $bitrixApi,
		protected ClientInstall\DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
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

		(new ClientInstall\Handler(
			$this->repo,
			$this->bitrixApi,
			$this->devCaseRunner,
			$this->logger,
		))($useCaseRequest);
	}

	private function formRequestForAnApp(Request $request): ClientInstall\Request
	{
		return new ClientInstall\Request(
			$this->retrieveClient($request),
			handlerUrl: $request->getRequestUri(),
			accessToken: $this->retrieveAccessToken($request),
		);
	}

	private function formRequestForAPlacement(Request $request): ClientInstall\Request
	{
		return new ClientInstall\Request(
			$this->retrieveClient($request),
			handlerUrl: $request->getRequestUri(),
			accessToken: $this->retrieveAccessToken($request)
		);
	}
}
