<?php

declare(strict_types=1);

namespace MockedApplication\Application\UseCase\Response;

class ApplicationInstallResponse
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
