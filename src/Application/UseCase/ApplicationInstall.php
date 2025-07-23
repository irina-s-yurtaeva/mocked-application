<?php

declare(strict_types=1);

namespace MockedApplication\Application\UseCase;

use MockedApplication\Application\UseCase\Request\ApplicationInstallRequest;
use MockedApplication\Application\UseCase\Response\ApplicationInstallResponse;
use MockedApplication\Application\Gateway\BitrixRestGateway;
use MockedApplication\Domain\Repository\ClientRepositoryInterface;

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
        );

		$this->clientRepository->saveAccessToken(
			$clientId,
			$this->gateway->getAccessToken(,
				$request->memberId,
				$request->domain,
				$request->clientEndpoint
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
