<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoRequestResolver implements ValueResolverInterface
{
	private const DTO_NAMESPACE = 'App\\Application\\UseCase\\Request\\';

	public function __construct(
		private readonly SerializerInterface $serializer,
		private readonly ValidatorInterface $validator
	) {}

	public function resolve(Request $request, ArgumentMetadata $argument): iterable
	{
		$type = $argument->getType();

		if (
			$type === null ||
			!class_exists($type) ||
			!str_starts_with($type, self::DTO_NAMESPACE)
		) {
			return [];
		}

		if (!in_array($request->getMethod(), ['POST', 'PUT', 'PATCH']) || !$request->getContent()) {
			throw new \InvalidArgumentException('Request body is required for DTO binding');
		}

		try {
			$dto = $this->serializer->deserialize($request->getContent(), $type, 'json');

			$errors = $this->validator->validate($dto);
			if ($errors->count() > 0) {
				$messages = [];
				foreach ($errors as $error) {
					$property = $error->getPropertyPath();
					$messages[$property] = $error->getMessage();
				}
				throw new \InvalidArgumentException('Validation failed: ' . json_encode($messages, JSON_UNESCAPED_UNICODE));
			}

			return [$dto];
		} catch (\Exception $e) {
			throw new \InvalidArgumentException('Invalid request: ' . $e->getMessage());
		}
	}
}
