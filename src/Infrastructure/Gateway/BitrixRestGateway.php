<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application;
use App\Infrastructure\Exception\BitrixApiException;
use App\Infrastructure\Exception\CurlTransportException;
use App\Infrastructure\Exception\ExpiredTokenException;
use App\Infrastructure\Exception\InternalServerErrorException;
use App\Infrastructure\Exception\InvalidClientException;
use App\Infrastructure\Exception\InvalidGrantException;
use App\Infrastructure\Exception\InvalidTokenException;
use App\Infrastructure\Exception\MethodNotFoundException;
use App\Infrastructure\Exception\NoAuthFoundException;
use App\Infrastructure\Exception\QueryLimitExceededException;
use App\Application\Gateway\AccessTokenProvider;
use App\Application\Gateway\BitrixUrlProvider;

final class BitrixRestGateway implements Application\Gateway\BitrixRestGateway
{
	protected const ATTEMPTS_TO_AUTH = 1;
	protected int $attemptsToAuth = 0;

    public function __construct(
		private string $clientId,
		private string $clientSecret,
        private readonly BitrixUrlProvider $urlProvider,
        private readonly AccessTokenProvider $accessTokenProvider,
	    private readonly bool $disableSslVerification = false,
	    private readonly string $encoding = 'UTF-8',
    ) {
    }

    public function call(string $method, array $params = []): array
    {
	    try
	    {
		    $url = $this->urlProvider->getEndpointUrlWithMethod($method); ;
		    $params['auth'] = $this->accessTokenProvider->getAccessToken();

		    $data = $this->justCurl($url, $params);

		    if (!is_array($data))
			{
			    throw new BitrixApiException('Invalid JSON response');
		    }

		    if (!empty($data['error'])) {
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
				$this->refreshAccessToken();

				return $this->call($method, $params);
			}

			throw $e;
	    }

        return $data;
    }

	public function getAccessToken(string $method, array $params = []): array
	{
		return [];
	}

	private function justCurl(string $url, array $params): array
	{
		$payload = http_build_query($params);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		if ($this->disableSslVerification)
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}


		$result = curl_exec($ch);

		if ($result === false)
		{
			$error = curl_error($ch);
			curl_close($ch);
			throw new CurlTransportException($error);
		}

		curl_close($ch);

		return $this->processResponse($result);
	}

	protected function refreshAccessToken(): void
	{
		$result = $this->justCurl(
			$this->urlProvider->getAuthenticationUrl(),
			[
				'client_id' => $this->clientId,
				'grant_type' => 'refresh_token',
				'client_secret' => $this->clientSecret,
				'refresh_token' => $this->accessTokenProvider->getRefreshToken(),
			]
		);

		$this->accessTokenProvider->refreshAccessToken($result);
	}

	protected function processResponse(string $data): array
	{
		return $this->encode(json_decode($data, true), 'UTF-8', $this->encoding);
	}

	protected function encode(array $data, string $from, string $into): array
	{
		if ($from === $into)
		{
			return $data;
		}

		$result = [];
		foreach ($data as $k => $item)
		{
			$k = iconv($from, $into, $k);
			$result[$k] = is_array($item) ? $this->encode($item, $from, $into) : iconv($from, $into, $item);
		}

		return $result;
	}
}
