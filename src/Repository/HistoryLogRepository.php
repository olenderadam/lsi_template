<?php

namespace App\Repository;

use App\Entity\HistoryLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryLog>
 *
 * @method HistoryLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryLog[]    findAll()
 * @method HistoryLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryLog::class);
    }

    public function add(HistoryLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryLog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getNames()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.export_name', 'ASC');
        $query = $qb->getQuery();

        $list = $query->execute();
        $array_list = [];
        foreach ($list as $value) {
            $array_list[$value->getExportName()] = $value->getExportName();
        }
        return $array_list;
    }
    public function findByFilterCrit($criteria)
    {

        $qb = $this->createQueryBuilder('p');
        if (isset($criteria['export_name'])) {
            $qb->andWhere('p.export_name = :export_name')
                ->setParameter('export_name', $criteria['export_name']);
        }
        if (isset($criteria['date_from']) && isset($criteria['date_to'])) {
            $qb->andWhere('p.export_date between :date_from and :date_to')
                ->setParameter('date_from', $criteria['date_from'])
                ->setParameter('date_to', $criteria['date_to']);
        }


        $query = $qb->getQuery();

        $models = $query->execute();

        return $models;
    }
}
