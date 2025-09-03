<?php

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
return function (array $context) {
	?><pre><b>$context: </b><?php print_r($context)?></pre><?php

	$request = Request::createFromGlobals();
	$kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);

	return $kernel->handle($request);
};
