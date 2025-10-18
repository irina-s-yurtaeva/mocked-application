<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Api\ClientSettings\v1;

use App\Application\Gateway\BitrixApiInterface;
use App\Application\UseCase\ClientHandle;
use App\Infrastructure\Controller\Api\BaseManager;
use App\Infrastructure\Repository\ClientRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class Manager extends BaseManager
{
	public function __construct(
		protected ClientRepository $repo,
		protected BitrixApiInterface $bitrixApi,
		protected ClientHandle\DevCaseRunner $devCaseRunner,
		protected LoggerInterface $logger,
	)
	{

	}

	public function handleGet(Request $request): array
	{
		return [
			'title' => 'E-Invoice Configuration Wizard',
			'steps' => [
				[
					'id'          => 'basic-info',
					'title'       => 'Basic Information',
					'description' => 'Please enter your company details.',
					'fields'      => [
						[
							'id'          => 'company_name',
							'name'        => 'Company Name',
							'type'        => 'input',
							'placeholder' => 'Enter company name',
							'label'       => 'Company Name',
							'value'       => 'Acme Corp'
						],
						[
							'id'          => 'country',
							'name'        => 'Country',
							'type'        => 'dropdown-list',
							'label'       => 'Select Country',
							'placeholder' => 'Choose a country',
							'value'       => 'DE',
							'items'       => [
								['value' => 'US', 'name' => 'United States'],
								['value' => 'DE', 'name' => 'Germany'],
								['value' => 'FR', 'name' => 'France'],
								['value' => 'RU', 'name' => 'Russia'],
							]
						]
					],
					'link' => [
						'name' => 'Need help?',
						'url'  => 'https://example.com/help/e-invoice'
					]
				],
				[
					'id'          => 'tax-settings',
					'title'       => 'Tax Configuration',
					'description' => 'Set up tax IDs and compliance options.',
					'fields'      => [
						[
							'id'    => 'tax_id',
							'name'  => 'VAT ID',
							'type'  => 'input',
							'label' => 'VAT Identification Number',
							'value' => 'DE276452187'
						]
					]
				]
			],

			// Form settings — used to populate handler, redirect, buttons
			'form' => [
				'action'       => $request->getSchemeAndHttpHost() . '/v1/settings/set/',  // becomes HANDLER
				'redirect'     => '/settings/saved.php',              // becomes REDIRECT (optional)
				'clientId'     => 'client_54321',                     // becomes CLIENT_ID (if used)
				'saveCaption'  => 'Save & Activate',                  // becomes SAVE_BUTTON
				'cancelCaption'=> 'Cancel',                           // becomes CANCEL_BUTTON
			]
		];
	}

	public function handleSet(): array
	{
		return [

		];
	}
}
