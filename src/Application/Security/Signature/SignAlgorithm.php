<?php

declare(strict_types=1);

namespace App\Application\Security\Signature;

interface SignAlgorithm
{
	public function apply(string $value, string $key): string;
}
