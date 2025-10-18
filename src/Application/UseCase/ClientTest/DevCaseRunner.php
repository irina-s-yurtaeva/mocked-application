<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientTest;

use App\Domain\Entity\Client;

class DevCaseRunner
{
	private array $results = [];
	private array $enabledCases;
	/**
	 * @param DevCase\DevCaseInterface[] $devCases
	 */
	public function __construct(
		private iterable $devCases,
		private array $enabledCaseNames
	) {
	}

	public function run(Client $client, array $devCaseNames): void
	{
		foreach ($this->getList() as $caseName => $case) {
			if (in_array($caseName, $devCaseNames)) {
				$case->handle($client);
				$this->results[$caseName] = $case->getResult();
			}
		}
	}

	public function getResults(): array
	{
		return $this->results;
	}

	public function getList(): array
	{
		if (!isset($this->enabledCases)) {
			$this->initEnabledCases();
		}

		return $this->enabledCases;
	}

	private function initEnabledCases(): void
	{
		$this->enabledCases = [];
		foreach ($this->devCases as $case) {
			$caseName = (new \ReflectionClass($case))->getShortName();

			if (!in_array($caseName, $this->enabledCaseNames, true)) {
				continue;
			}

			$this->enabledCases[$caseName] = $case;
		}
	}
}
