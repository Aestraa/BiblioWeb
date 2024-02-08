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

    public function findByMultipleCriteria(string $categorie = null, string $titre = null, string $auteurNom = null, string $auteurPrenom = null, \DateTimeInterface $dateSortie = null, string $langue = null): array
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->select('l')
            ->leftJoin('l.categories', 'c') // Assurez-vous que l'association categories est correctement configurée dans votre entité Livre
            ->leftJoin('l.auteurs', 'a'); // Assurez-vous que l'association auteurs est correctement configurée dans votre entité Livre

        if ($categorie !== null) {
            $queryBuilder->andWhere('c.nom = :categorie')
                ->setParameter('categorie', $categorie);
        }

        if ($titre !== null) {
            // Si le titre est incomplet, recherchez les livres dont le titre contient la sous-chaîne fournie
            $queryBuilder->andWhere('l.titre LIKE :titre')
                ->setParameter('titre', '%' . $titre . '%');
        }

        if ($auteurNom !== null) {
            $queryBuilder->andWhere('a.nom = :auteurNom')
                ->setParameter('auteurNom', $auteurNom);
        }

        if ($auteurPrenom !== null) {
            $queryBuilder->andWhere('a.prenom = :auteurPrenom')
                ->setParameter('auteurPrenom', $auteurPrenom);
        }

        if ($dateSortie !== null) {
            $queryBuilder->andWhere('l.dateSortie >= :dateSortie')
                ->setParameter('dateSortie', $dateSortie);
        }

        if ($langue !== null) {
            $queryBuilder->andWhere('l.langue = :langue')
                ->setParameter('langue', $langue);
        }

        return $queryBuilder->getQuery()->getResult();
    }

}
