<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepository;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;
use SplFileObject;
use DateTime;

class NewsService
{
    public function __construct(
        private readonly NewsRepository $repository,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function import(string $fileName): void
    {
        $file = new SplFileObject($fileName, "r");

        if ('json' !== $file->getFileInfo()->getExtension()) {
            throw new RuntimeException(
                \sprintf('File "%s" is not a valid JSON file.', $fileName),
            );
        }

        $contents = $file->fread($file->getSize());

        $data = $this->serializer->deserialize($contents, 'App\Entity\News[]', 'json');

        $this->repository->bulkInsert($data);
    }

    /**
     * @return array<News>
     */
    public function getByPublishDate(DateTime $publishDate): array
    {
        return $this->repository->findByPublishDate($publishDate);
    }
}
