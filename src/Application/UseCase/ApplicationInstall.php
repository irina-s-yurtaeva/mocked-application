<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\ApplicationInstallRequest;
use App\Application\UseCase\Response\ApplicationInstallResponse;
use App\Application\Gateway\BitrixRestGateway;
use App\Domain\Repository\ClientRepositoryInterface;

class ApplicationInstall
{
    public function __construct(
        protected ClientRepositoryInterface $clientRepository,
	    protected BitrixRestGateway $gateway,
    ) {
    }

    public function __invoke(ApplicationInstallRequest $request): ApplicationInstallResponse
    {
        $clientId = $this->clientRepository->saveClient(
            $request->memberId,
            $request->domain,
            $request->clientEndpoint
        );

		$this->clientRepository->saveAccessToken(
			$clientId,
			$this->gateway->getAccessToken(
				$request->memberId,
				$request->domain,
				$request->clientEndpoint,
				$request->accessToken,
				$request->expiresIn,
				$request->applicationToken,
				$request->refreshToken
			)
		);



		$this->gateway->call(
			'event.bind',
			[
				'EVENT' => 'ONCRMCONTACTUPDATE',
				'HANDLER' => $request->handlerUrl,
				'EVENT_TYPE' => 'online'
			]
		);

	    $this->gateway->call(
		    'event.bind',
		    [
			    'EVENT' => 'ONCRMCONTACTADD',
			    'HANDLER' => $request->handlerUrl,
			    'EVENT_TYPE' => 'online'
		    ]
	    );

        return new ApplicationInstallResponse($id);
    }
}
