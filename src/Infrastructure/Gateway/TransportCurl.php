<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Exception\CurlTransportException;

class TransportCurl implements Transport
{
	public function __construct(
		protected bool $disableSslVerification = false,
		protected string $encoding = 'UTF-8',
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
		if ($from === $into)
		{
			return $data;
		}

		$result = [];
		foreach ($data as $k => $item)
		{
			$k = iconv($from, $into, $k);
			$result[$k] = is_array($item) ? $this->encode($item, $from, $into) : iconv($from, $into, $item);
		}

		return $result;
	}
}
