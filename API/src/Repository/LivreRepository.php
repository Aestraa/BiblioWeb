<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

//    /**
//     * @return Livre[] Returns an array of Livre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByPartialTitle(string $query)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }


    public function findByCategory(string $category): array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.categories', 'c')
            ->where('c.nom = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findByAuthor(string $nom, string $prenom): array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.auteurs', 'a')
            ->where('a.nom = :nom')
            ->andWhere('a.prenom = :prenom')
            ->setParameter('nom', $nom)
            ->setParameter('prenom', $prenom)
            ->getQuery()
            ->getResult();
    }

    public function findByCreationDate(string $date): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.dateSortie > :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    public function findByNationality(string $langue): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.langue = :langue')
            ->setParameter('langue', $langue)
            ->getQuery()
            ->getResult();
    }
}
