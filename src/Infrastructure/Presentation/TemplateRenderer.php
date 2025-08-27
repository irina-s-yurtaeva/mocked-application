<?php

declare(strict_types=1);

namespace App\Infrastructure\Presentation;

class TemplateRenderer
{
	public function __construct(
		private readonly string $templateDir
	) {}

	public function render(string $template, array $parameters = []): string
	{
		$file = $this->templateDir . '/' . $template;

		if (!file_exists($file)) {
			throw new \InvalidArgumentException("Template not found: $file");
		}

		extract($parameters);
		ob_start();
		include $file;
		return ob_get_clean();
	}
}
