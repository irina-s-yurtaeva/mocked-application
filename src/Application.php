<?php

declare(strict_types=1);

namespace MockedApplication;

use MockedApplication;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Application
{
        protected Request $request;
        protected EntityManager $entityManager;
        protected Connection $connection;

        public function __construct(
                protected string $applicationPublicId,
                protected string $applicationPrivateId,
                string $dbHost,
				string $dbName,
				string $dbUser,
	            string $dbPassword,
        )
        {
                $this->request = Request::createFromGlobals();
                $config = ORMSetup::createAttributeMetadataConfiguration([
                        __DIR__ . '/Domain/Entity'
                ], true);

                $connectionParams = [
                        'driver' => 'pdo_mysql',
                        'host' => getenv('DB_HOST') ?: 'localhost',
                        'dbname' => getenv('DB_NAME'),
                        'user' => getenv('DB_USER'),
                        'password' => getenv('DB_PASS'),
                        'charset' => 'utf8mb4',
                ];

                $this->connection = DriverManager::getConnection($connectionParams);
                $this->entityManager = new EntityManager($this->connection, $config);
        }

	public function install(
		string $eventHandlerUrl,
	): void
	{
		$eventHandlerUrl = $this->request->getSchemeAndHttpHost() . $eventHandlerUrl;
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
				handlerUrl: $eventHandlerUrl,
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
				handlerUrl: $eventHandlerUrl,
			);
		}

        if (isset($applicationInstallRequest))
        {
            (new MockedApplication\Application\UseCase\ApplicationInstall(
                    new MockedApplication\Infrastructure\Repository\ClientSettingsRepository(
                            $this->entityManager,
                            $this->connection
                    ),
	                new MockedApplication\Infrastructure\BitrixRestGateway(
			                $this->request->get('auth')['domain'],
			                $this->request->get('auth')['access_token']
	                );
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
