<?php

declare(strict_types=1);

namespace App\Application\Security\Signature;

class Verifier
{
	protected string $key;

	public function __construct(protected Signer $signer)
	{
	}

	public function check(mixed $value, string $signature): bool
	{
		$actualSignature = $this->signer->sing($value);

		return $this->compareStrings($actualSignature, $signature);
	}

	protected function compareStrings(string $actualSignature, string $expectedSignature): bool
	{
		$lenExpected = strlen($expectedSignature);
		$lenActual = strlen($actualSignature);

		$status = $lenExpected ^ $lenActual;
		$len = min($lenExpected, $lenActual);
		for ($i = 0; $i < $len; $i++)
		{
			$status |= ord($expectedSignature[$i]) ^ ord($actualSignature[$i]);
		}

		return $status === 0;
	}
}
