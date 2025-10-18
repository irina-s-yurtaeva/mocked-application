<?php

declare(strict_types=1);

namespace App\Application\Security\Signature;

class SignAlgorithmMd5  implements SignAlgorithm
{
	public function apply(string $value, string $key): string
	{
		return md5($value . $key);
	}
}
