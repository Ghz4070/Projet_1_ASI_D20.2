<?php

namespace App\Repository;

use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vote[]    findAll()
 * @method Vote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    public function averageTopDix()
    {
        return $this->createQueryBuilder('v')// Base pour crée nimporte quelle requete
        ->select("avg(v.score) as score_avg, c.name, c.id")// Select ou Insert ou Update ou Delete
        ->join("v.conference", 'c')// Jointure sur la table conference
        ->groupBy('v.conference') // regroupe par conference
            ->orderBy('score_avg', 'desc')// desc: grand->petit en fonction de la moyenne (asc : petit->grand)
            ->setMaxResults(10)// LIMIT = 10
            ->getQuery()
            ->getResult();
    }

    public function averageByUser($parameter){
        return $this->createQueryBuilder('v')
            ->select("avg(v.score) as scoreAvg, c.name, c.description, c.createdAt, c.id")
            ->join('v.conference', 'c')
            ->join('v.user','u')
            ->where('v.user = :parameter')
            ->groupBy('c.id')
            ->setParameter('parameter', $parameter)
            ->getQuery()
            ->getResult();
    }

    public function averageWithoutUser($parameter){
        return $this->createQueryBuilder('v')
            ->select("avg(v.score) as scoreAvg, c.name, c.description, c.createdAt, c.id")
            ->join('v.conference', 'c')
            ->join('v.user','u')
            ->where('v.user != :parameter')
            ->groupBy('c.id')
            ->setParameter('parameter', $parameter)
            ->getQuery()
            ->getResult();
    }

    public function avg(){
        return $this->createQueryBuilder('v')
            ->select("avg(v.score) as scoreAvg, c.id ")
            ->join('v.conference', 'c')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Vote[] Returns an array of Vote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vote
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
