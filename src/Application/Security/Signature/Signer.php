<?php

declare(strict_types=1);

namespace App\Application\Security\Signature;

use App\Domain\Entity\Client;

class Signer
{
	protected string $key;

	public function __construct(
		protected SignAlgorithm $algorithm,
		protected string $clientSecret,
		protected Client $client,
	)
	{
		$this->key = md5($this->client->getMemberId() . $this->clientSecret);
	}

	public function sing(mixed $value): string
	{
		$data = base64_encode(json_encode($value));
		return $this->algorithm->apply($data, $this->key);
	}
}
