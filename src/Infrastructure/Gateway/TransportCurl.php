<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Exception\CurlTransportException;
use Psr\Log\LoggerInterface;

class TransportCurl implements Transport
{
	public function __construct(
		protected bool $disableSslVerification = false,
		protected string $encoding = 'UTF-8',
		protected LoggerInterface $logger,
	) {
	}

	public function processRequest(string $url, array $params): array
	{
		$payload = http_build_query($params);

		$ch = \curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		if ($this->disableSslVerification)
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}


		$result = curl_exec($ch);

		if ($result === false)
		{
			$error = curl_error($ch);
			curl_close($ch);
			throw new CurlTransportException($error);
		}

		curl_close($ch);

		return $this->processResponse($result);
	}

	public function processResponse(string $data): array
	{
		return $this->encode(json_decode($data, true), 'UTF-8', $this->encoding);
	}

	protected function encode(array $data, string $from, string $into): array
	{
		if (mb_strtolower($from) === mb_strtolower($into))
		{
			return $data;
		}

		$result = [];
		foreach ($data as $k => $item)
		{
			$k = iconv($from, $into, $k);
			if (is_string($item))
			{
				$result[$k] = mb_convert_encoding($item, 'UTF-8', $into);
			}
			else if (is_array($item))
			{
				$result[$k] = $this->encode($item, $from, $into);
			}
			else
			{
				$result[$k] = $item;
			}
		}

		return $result;
	}
}
