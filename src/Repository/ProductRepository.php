<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Vous pouvez ajouter des méthodes de requête personnalisées ici si nécessaire

    public function findByType(?int $typeId = null)
    {
        $qb = $this->createQueryBuilder('p');

        if ($typeId !== null) {
            $qb->andWhere('p.types = :typeId')
                ->setParameter('typeId', $typeId);
        }

        return $qb->getQuery()->getResult();
    }
}
