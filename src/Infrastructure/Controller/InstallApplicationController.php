<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class InstallApplicationController extends AbstractController
{
	public function index(): Response
	{
		return new Response('Installation page — works!');
	}
}
