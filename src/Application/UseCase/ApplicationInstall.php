<?php

declare(strict_types=1);

namespace MockedApplication\Application\UseCase;

use MockedApplication\Application\UseCase\Request\ApplicationInstallRequest;
use MockedApplication\Application\UseCase\Response\ApplicationInstallResponse;
use MockedApplication\Domain\Repository\ClientSettingsRepositoryInterface;

class ApplicationInstall
{
    public function __construct(
		protected ClientSettingsRepositoryInterface $clientSettingsRepository,
	    protected
    ) {
    }

    public function __invoke(ApplicationInstallRequest $request): ApplicationInstallResponse
    {
	    $this->clientSettingsRepository->saveClientSettings(
		    $request->memberId,
		    $request->accessToken,
		    $request->expiresIn,
		    $request->applicationToken,
		    $request->refreshToken,
		    $request->domain,
		    $request->clientEndpoint
	    );

	    $handlerBackUrl = ($_SERVER['HTTPS'] === 'on' || $_SERVER['SERVER_PORT'] === '443' ? 'https' : 'http') . '://'
		    . $_SERVER['SERVER_NAME']
		    . (in_array($_SERVER['SERVER_PORT'],	['80', '443'], true) ? '' : ':' . $_SERVER['SERVER_PORT'])
		    . str_replace($_SERVER['DOCUMENT_ROOT'], '',__DIR__)
		    . '/handler.php';

	    $result = CRestExt::call(
		    'event.bind',
		    [
			    'EVENT' => 'ONCRMCONTACTUPDATE',
			    'HANDLER' => $handlerBackUrl,
			    'EVENT_TYPE' => 'online'
		    ]
	    );

	    $result = CRestExt::call(
		    'event.bind',
		    [
			    'EVENT' => 'ONCRMCONTACTADD',
			    'HANDLER' => $handlerBackUrl,
			    'EVENT_TYPE' => 'online'
		    ]
	    );
    }
}
