<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\NewsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class NewsController
{
    public function __construct(private readonly NewsService $newsService)
    {
    }

    #[Route('/api/news/{publishDate}', name: 'get_news_by_publish_date')]
    public function getByPublishDate(string $publishDate): Response
    {
        try {
            $publishDate = new DateTime($publishDate);
        } catch (\Throwable) {
            return new JsonResponse([
                'error' => 'Invalid publish date',
            ]);
        }

        try {
            $data = $this->newsService->getByPublishDate($publishDate);

            return new JsonResponse([
                'totalResults' => count($data),
                'news' => $data
            ]);
        } catch (\Throwable $exception) {
            return new JsonResponse([
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
