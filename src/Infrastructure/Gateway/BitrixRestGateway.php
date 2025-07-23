<?php

declare(strict_types=1);

namespace MockedApplication\Infrastructure\Gateway;

use MockedApplication\Application\Gateway\BitrixRestGateway as BitrixRestGatewayInterface;
use MockedApplication\Application\Port\AccessTokenProvider;
use MockedApplication\Infrastructure\Exception\BitrixApiException;
use MockedApplication\Infrastructure\Exception\CurlTransportException;
use MockedApplication\Infrastructure\Exception\ExpiredTokenException;
use MockedApplication\Infrastructure\Exception\InvalidTokenException;
use MockedApplication\Infrastructure\Exception\InvalidGrantException;
use MockedApplication\Infrastructure\Exception\InvalidClientException;
use MockedApplication\Infrastructure\Exception\QueryLimitExceededException;
use MockedApplication\Infrastructure\Exception\MethodNotFoundException;
use MockedApplication\Infrastructure\Exception\NoAuthFoundException;
use MockedApplication\Infrastructure\Exception\InternalServerErrorException;

final class BitrixRestGateway implements BitrixRestGatewayInterface
{
    public function __construct(
        private readonly string $tenantId,
        private readonly string $clientEndpoint,
        private readonly AccessTokenProvider $accessTokenProvider,
    ) {
    }

    public function call(string $method, array $params = [], ?string $accessToken = null): array
    {
        $token = $accessToken ?? $this->accessTokenProvider->getAccessTokenForTenant($this->tenantId);
        $url = rtrim($this->clientEndpoint, '/') . '/' . $method . '.json';
        $params['auth'] = $token;
        $payload = http_build_query($params);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $result = curl_exec($ch);

        if ($result === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new CurlTransportException($error);
        }

        curl_close($ch);

        $data = json_decode($result, true);
        if (!is_array($data)) {
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

        return $data;
    }
}
