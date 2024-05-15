<?php

namespace App\Repository;

use App\Entity\Disponibilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Disponibilite>
 */
class DisponibiliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disponibilite::class);
    }

    /**
     * @return Disponibilite[] Returns an array of Disponibilite objects
     */
    public function findByDate($citeres): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.date_debut <= :date_debut')
            ->setParameter('date_debut', $citeres['date_debut'])
            ->andWhere('d.date_fin >= :date_fin')
            ->setParameter('date_fin', $citeres['date_fin'])
            ->andWhere('d.prix_jour <= :prix_max')
            ->setParameter('prix_max', $citeres['prix_max'])
            ->andWhere('d.statut = 1')
            ->orderBy('d.id', 'ASC')            
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Disponibilite[] Returns an array of Disponibilite objects for a vehicle
     */
    public function getDisponibilitiesForVehicule(\DateTimeInterface $dateDebut, \DateTimeInterface $dateFin, int $vehiculeId, $idDisponibiliteCourante = null): array
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->where('d.date_debut between :date_debut and :date_fin')
            ->orWhere('d.date_fin between :date_debut and :date_fin')
            ->orWhere(':date_debut between d.date_debut and d.date_fin')            
            ->andWhere('d.vehicule = :vehicule_id')  
            ->setParameter('date_debut', $dateDebut)
            ->setParameter('date_fin', $dateFin)
            ->setParameter('vehicule_id', $vehiculeId);

            if ($idDisponibiliteCourante !== null) {
                $queryBuilder->andWhere('d.id != :currentDisponibiliteId')
                             ->setParameter('currentDisponibiliteId', $idDisponibiliteCourante);
            }
            return $queryBuilder->getQuery()->getResult();
        ;
    }
    //    public function findOneBySomeField($value): ?Disponibilite
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
