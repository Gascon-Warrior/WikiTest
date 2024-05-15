<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Vehicule;
use App\Entity\Disponibilite;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '/data.json'), true);
        
        foreach ($data['vehicules'] as $item) {
            $vehicule = new Vehicule();
            $vehicule->setMarque($item['marque']);
            $vehicule->setModele($item['modele']);
            
            $manager->persist($vehicule);
            
            foreach ($item['disponibilites'] as $dispoData) {
                $disponibilite = new Disponibilite();
                $disponibilite->setDateDebut(new \DateTime($dispoData['date_debut']));
                $disponibilite->setDateFin(new \DateTime($dispoData['date_fin']));
                $disponibilite->setPrixJour($dispoData['prix_jour']);
                $disponibilite->setStatut($dispoData['statut']);
                $disponibilite->setVehicule($vehicule);

                $manager->persist($disponibilite);
            }
            
        }

        $manager->flush();
    }
}
