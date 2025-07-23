<?php

declare(strict_types=1);

namespace MockedApplication;

use MockedApplication;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Application
{
        protected Request $request;
        protected Connection $connection;

        public function __construct(
                string $applicationPublicId,
                string $applicationPrivateId,
        )
        {
                $this->request = Request::createFromGlobals();
                $this->connection = DriverManager::getConnection([
                        'url' => getenv('DATABASE_URL'),
                ]);
        }

	public function install(): void
	{
		if ($this->request->get('event') === 'ONAPPINSTALL' && !empty($this->request->get('auth')))
		{
			$applicationInstallRequest = new MockedApplication\Application\UseCase\Request\ApplicationInstallRequest(
				memberId: $this->request->get('auth')['member_id'],
				accessToken: $this->request->get('auth')['access_token'],
				expiresIn: $this->request->get('auth')['expires_in'],
				applicationToken: $this->request->get('auth')['application_token'],
				refreshToken: $this->request->get('auth')['refresh_token'],
				domain: $this->request->get('auth')['domain'],
				clientEndpoint: $this->request->get('auth')['client_endpoint'],
			);
		}
		elseif ($this->request->get('PLACEMENT') === 'DEFAULT')
		{
			$applicationInstallRequest = new MockedApplication\Application\UseCase\Request\ApplicationInstallRequest(
				memberId: $this->request->get('member_id'),
				accessToken: ($this->request->get('AUTH_ID')),
				expiresIn: ($this->request->get('AUTH_EXPIRES')),
				applicationToken: ($this->request->get('APP_SID')),
				refreshToken: ($this->request->get('REFRESH_ID')),
				domain: ($this->request->get('DOMAIN')),
				clientEndpoint: 'https://' . $this->request->get('DOMAIN') . '/rest/',
			);
		}

                if (isset($applicationInstallRequest))
                {
                        (new MockedApplication\Application\UseCase\ApplicationInstall(
                                new MockedApplication\Infrastructure\Repository\ClientSettingsRepository($this->connection)
                        ))(
                                $applicationInstallRequest
                        );
                }
	}

	public function uninstall(): void
	{

	}

	public function handleEvent(): void
	{

	}

	public function showDemo()
	{

	}
}
