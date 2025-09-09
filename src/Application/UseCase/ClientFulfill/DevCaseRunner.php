<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientFulfill;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

class DevCaseRunner
{
	private array $results = [];
	/**
	 * @param DevCase\DevCaseInterface[] $devCases
	 */
	public function __construct(
		private iterable $devCases,
		private array $enabledCases
	) {
	}

	public function run(
		Request $request,
		Client $client,
		AccessToken $accessToken
	): void
	{

		foreach ($this->devCases as $case) {
			$caseName = (new \ReflectionClass($case))->getShortName();

			if (!in_array($caseName, $this->enabledCases, true)) {
				continue;
			}
			$case->handle($request, $client, $accessToken);

			$this->results[$caseName] = $case->getResult();
		}
	}

	public function getResults(): array
	{
		return $this->results;
	}
}
