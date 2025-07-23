<?php

declare(strict_types=1);

namespace MockedApplication\Application\UseCase;

use MockedApplication\Application\UseCase\Request\ApplicationInstallRequest;
use MockedApplication\Application\UseCase\Response\ApplicationInstallResponse;
use MockedApplication\Application\BitrixRestGateway;
use MockedApplication\Domain\Repository\ClientSettingsRepositoryInterface;
use src\Internal\CRestExt;

class ApplicationInstall
{
    public function __construct(
        protected ClientSettingsRepositoryInterface $clientSettingsRepository,
	    protected BitrixRestGateway $gateway,
    ) {
    }

    public function __invoke(ApplicationInstallRequest $request): ApplicationInstallResponse
    {
        $id = $this->clientSettingsRepository->saveClientSettings(
            $request->memberId,
            $request->accessToken,
            $request->expiresIn,
            $request->applicationToken,
            $request->refreshToken,
            $request->domain,
            $request->clientEndpoint
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
