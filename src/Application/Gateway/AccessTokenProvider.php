<?php

declare(strict_types=1);

namespace MockedApplication\Application\Gateway;

interface AccessTokenProvider
{
	public function getAccessToken(): string;

	public function getRefreshToken(): string;

	public function getExpiresIn(): string;

	public function getApplicationToken(): string;

	public function getUserId(array $data): ?int;

	public function getUserFullNAme(array $data): ?string;

	public function refreshAccessToken(array $data): void;

}
