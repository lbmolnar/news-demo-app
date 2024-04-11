<?php

declare(strict_types=1);

namespace App\Denormalizer;

use App\Entity\News;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class NewsDenormalizer implements DenormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly ObjectNormalizer $normalizer,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        /** @var News $news */
        $news = $this->normalizer->denormalize($data, $type, $format, $context);

        $author = null;
        $persons = $data['byline']['person'] ?? [];
        $person = array_shift($persons);

        if (null !== $person) {
            $author = $person['firstname'];

            $middleName = $person['middlename'] ?? null;
            $lastName = $person['lastname'] ?? null;

            if (null !== $middleName) {
                $author = $author . ' ' . $middleName;
            }

            if (null !== $lastName) {
                $author = $author . ' ' . $lastName;
            }

            $author = trim($author);
        }

        $news->setAuthor((null !== $author && 0 !== strlen($author)) ? $author : null);

        return $news;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        // all news must have abstract, otherwise this denormalizer will not work
        return true === is_array($data) && true === isset($data['abstract']);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            News::class => true,
        ];
    }
}
