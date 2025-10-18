<?php

declare(strict_types=1);

namespace App\Application\Security\Signature;

class HmacAlgorithmMd5  implements SignAlgorithm
{
	protected string $algorithm = 'sha256';

	public function apply(string $value, string $key): string
	{
		return hash_hmac($this->algorithm, $value, $key);
	}
}
