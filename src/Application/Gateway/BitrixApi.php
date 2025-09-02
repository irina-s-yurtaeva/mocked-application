<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Application\Exception\BitrixApiException;
use App\Application\Exception\CurlTransportException;
use App\Application\Exception\ExpiredTokenException;
use App\Application\Exception\InternalServerErrorException;
use App\Application\Exception\InvalidClientException;
use App\Application\Exception\InvalidGrantException;
use App\Application\Exception\InvalidTokenException;
use App\Application\Exception\MethodNotFoundException;
use App\Application\Exception\NoAuthFoundException;
use App\Application\Exception\QueryLimitExceededException;
use App\Domain\Entity\AccessToken;

abstract class BitrixApi implements BitrixApiInterface
{
	protected const ATTEMPTS_TO_AUTH = 1;
	protected int $attemptsToAuth = 0;

	public function __construct(
		private readonly BitrixUrlProvider $urlProvider,
		private readonly AccessTokenRefresher $accessTokenRefresher,
	) {
	}

	public function call(string $method, AccessToken $accessToken, array $params = []): array
	{
		try
		{
			$url = $this->urlProvider->getEndpointUrlWithMethod($method);
			$params['auth'] = $accessToken->getAccessToken();

			$data = $this->processRequest($url, $params);

			if (!empty($data['error']))
			{
				$message = $data['error_description'] ?? ($data['error_information'] ?? $data['error']);
				throw match ($data['error']) {
					'expired_token' => new ExpiredTokenException($message),
					'invalid_token' => new InvalidTokenException($message),
					'invalid_grant' => new InvalidGrantException($message),
					'invalid_client' => new InvalidClientException($message),
					'QUERY_LIMIT_EXCEEDED' => new QueryLimitExceededException($message),
					'ERROR_METHOD_NOT_FOUND' => new MethodNotFoundException($message),
					'NO_AUTH_FOUND' => new NoAuthFoundException($message),
					'INTERNAL_SERVER_ERROR' => new InternalServerErrorException($message),
					'curl_error' => new CurlTransportException($message),
					default => new BitrixApiException($message),
				};
			}
		}
		catch (ExpiredTokenException $e)
		{
			if ($this->attemptsToAuth < self::ATTEMPTS_TO_AUTH)
			{
				$this->attemptsToAuth++;
				$newAccessToken = $this->accessTokenRefresher->refresh($accessToken);

				return $this->call($method, $newAccessToken, $params);
			}

			throw $e;
		}

		return $data;
	}

	abstract protected function processRequest(string $url, array $params): array;
}
