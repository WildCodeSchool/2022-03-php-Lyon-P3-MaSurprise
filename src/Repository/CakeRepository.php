<?php

namespace App\Repository;

use App\Entity\Cake;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Cake>
 *
 * @method Cake|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cake|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cake[]    findAll()
 * @method Cake[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cake::class);
    }

    public function add(Cake $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cake $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // fetching cakes whose names match searched words
    public function findLikeName(mixed $name): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.baker', 'b')
            ->addSelect('b')
            ->where('c.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('c.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    // fetching cakes whose descriptions match searched words
    public function findLikeDescription(mixed $description): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.baker', 'b')
            ->addSelect('b')
            ->where('c.description LIKE :description')
            ->setParameter('description', '%' . $description . '%')
            ->orderBy('c.description', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    // fetching cakes whose bakers match searched words (using join)
    public function findLikeBaker(mixed $bakerName): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.baker', 'b')
            ->join('b.user', 'u')
            ->addSelect('b')
            ->where('u.lastname LIKE :baker_name')
            ->setParameter('baker_name', '%' . $bakerName . '%')
            ->orderBy('u.lastname', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    // fetching cakes with the right department (using join)
    public function findByDepartment(string $department): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
        ->join('c.baker', 'b')
        ->join('b.deliveryAddress', 'a') // department
        ->join('a.department', 'd') // department
        ->join('b.user', 'u')
        ->where('a.department = :department') // department
        ->setParameter('department', $department) // department
        ->orderBy('a.department', 'ASC')
        ->getQuery();

        return $queryBuilder->getResult();
    }

    // fetching cakes whose names match searched words
    public function findLikeNameWithLocation(mixed $name, string $department): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.baker', 'b')
            ->join('b.deliveryAddress', 'a') // department
            ->addSelect('b')
            ->where('c.name LIKE :name')
            ->andWhere('a.department = :department') // department
            ->setParameter('name', '%' . $name . '%')
            ->setParameter('department', $department) // department
            ->orderBy('c.name', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    // fetching cakes whose descriptions match searched words
    public function findLikeDescriptionWithLocation(mixed $description, mixed $department): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.baker', 'b')
            ->join('b.deliveryAddress', 'a') // department
            ->addSelect('b')
            ->where('c.description LIKE :description')
            ->andWhere('a.department = :department') // department
            ->setParameter('description', '%' . $description . '%')
            ->setParameter('department', $department) // department
            ->orderBy('c.description', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    // fetching cakes whose bakers match searched words (using join)
    public function findLikeBakerWithLocation(mixed $bakerName, mixed $department): mixed
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->join('c.baker', 'b')
            ->join('b.deliveryAddress', 'a') // department
            ->join('b.user', 'u')
            ->addSelect('b')
            ->where('u.lastname LIKE :baker_name')
            ->andWhere('a.department = :department') // department
            ->setParameter('baker_name', '%' . $bakerName . '%')
            ->setParameter('department', $department) // department
            ->orderBy('u.lastname', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

//    /**
//     * @return Cake[] Returns an array of Cake objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cake
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
