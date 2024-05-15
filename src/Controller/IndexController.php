<?php

namespace App\Controller;

use App\Form\SearchAvailabilitiesType;
use App\Repository\DisponibiliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index_')]
    public function index(DisponibiliteRepository $disponibiliteRepository, Request $request): Response
    {
        $searchForm = $this->createForm(SearchAvailabilitiesType::class);
        $searchForm->handleRequest($request);
    
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
    
            $criteres = $searchForm->getData();
            $prixMax = $searchForm->get('prix_max')->getData();
            $criteres['prix_max'] = $prixMax;
    
            // Je sauvegarde les dates originales
            $DateDebutOriginale = clone $criteres['date_debut'];
            $DateFinOriginale = clone $criteres['date_fin'];
    
            $disponibilites = $disponibiliteRepository->findByDate($criteres);
    
            // Si aucune disponibilité selon les dates, je relance la requête avec des dates flexibles à +/- 1 jour           
            if (!$disponibilites) {
                $ajustements = [
                    ['-1 day', '+1 day'],
                    ['-1 day', '0 day'],
                    ['-1 day', '-1 day'],
                    ['0 day', '+1 day'],
                    ['+1 day', '-1 day'],
                    ['+1 day', '0 day'],
                    ['+1 day', '+1 day'],                    
                    ['0 day', '-1 day']
                ];
    
                foreach ($ajustements as $ajustement) {
                    $criteres['date_debut'] = (clone $DateDebutOriginale)->modify($ajustement[0]);
                    $criteres['date_fin'] = (clone $DateFinOriginale)->modify($ajustement[1]);
                    $disponibilites = $disponibiliteRepository->findByDate($criteres);
    
                    if ($disponibilites) {
                        dump('Trouvé avec ajustement', $ajustement, $criteres['date_debut'], $criteres['date_fin']);
                        break;
                    }
                }
            }
    
            return $this->render('index/results.html.twig', [
                'disponibilites' => $disponibilites
            ]);
        }
    
        return $this->render('index/index.html.twig', [
            'searchForm' => $searchForm->createView(),
        ]);
    } 
}
