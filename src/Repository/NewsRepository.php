<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository
{
    private const int INSERT_BATCH_SIZE = 50;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @param array<News> $data
     */
    public function bulkInsert(array $data): void
    {
        $em = $this->getEntityManager();
        $currentItem = 1;

        foreach ($data as $news) {
            $currentItem++;
            $em->persist($news);

            if ($currentItem % self::INSERT_BATCH_SIZE === 0) {
                $em->flush();
                $em->clear();
            }
        }

        $em->flush();
        $em->clear();
    }

    /**
     * @return array<News>
     */
    public function findByPublishDate(\DateTime $publishDate): array
    {
        $qb = $this->createQueryBuilder('n');
        $qb->where('n.publishedAt >= :after');
        $qb->andWhere('n.publishedAt <= :before');
        $qb->setParameter('after', $publishDate->format('Y-m-d') . ' 00:00:00');
        $qb->setParameter('before', $publishDate->format('Y-m-d') . ' 23:59:59');

        return $qb->getQuery()->getResult();
    }
}
