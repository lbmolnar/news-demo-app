<?php

declare(strict_types=1);

namespace Service;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Service\NewsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;

class NewsServiceTest extends TestCase
{
    private SerializerInterface|MockObject $serializerMock;
    private NewsRepository|MockObject $newsRepositoryMock;
    private NewsService $newsService;

    public function setUp(): void
    {
        $this->newsRepositoryMock = $this->createMock(NewsRepository::class);
        $this->serializerMock = $this->createMock(SerializerInterface::class);
        $this->newsService = new NewsService($this->newsRepositoryMock, $this->serializerMock);
    }

    public function testImportWithInExistentFile(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed to open stream: No such file or directory');

        $this->newsService->import('tests/data/test.xml');
    }

    public function testImportWithFileHavingWrongExtension(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('File "tests/data/test.txt" is not a valid JSON file.');

        $this->newsService->import('tests/data/test.txt');
    }

    public function testImport(): void
    {
        $news = [new News()];
        $this->serializerMock
            ->expects($this->once())
            ->method('deserialize')
            ->willReturn($news);
        $this->newsRepositoryMock
            ->expects($this->once())
            ->method('bulkInsert')
            ->with($news);
        $this->newsService->import('tests/data/test.json');
    }
}
