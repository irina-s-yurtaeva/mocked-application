<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientHandler\v1;

use App\Application\Gateway\BitrixApiInterface;
use App\Application\UseCase\ClientHandle;
use App\Infrastructure\Controller\Api\BaseManager;
use App\Infrastructure\Repository\ClientRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class Manager extends BaseManager
{
	public function __construct(
		protected ClientRepository $repo,
		protected BitrixApiInterface $bitrixApi,
		protected ClientHandle\DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
	)
	{

	}

	public function handle(Request $request): void
	{
		$this->logger->info('Handle request', ['request' => $request->request->all()]);

		(new ClientHandle\Handler(
			$this->repo,
			$this->bitrixApi,
			$this->devCaseRunner,
			$this->logger,
		))(
			new ClientHandle\Request(
				$this->retrieveClient($request),
				$this->retrieveAccessToken($request),
		));
	}
}
