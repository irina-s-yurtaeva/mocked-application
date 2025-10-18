<?php

declare(strict_types=1);

namespace App\Application\UseCase\ClientTest\DevCase;

use App\Domain\Entity\AccessToken;
use App\Domain\Entity\Client;

interface DevCaseInterface
{
	public function getTitle(): string;
	public function handle(Client $client): void;
	public function getResult(): mixed;
}
