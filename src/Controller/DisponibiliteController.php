<?php

namespace App\Controller;

use App\Entity\Disponibilite;
use App\Form\DisponibiliteType;
use App\Repository\DisponibiliteRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/disponibilite', name: 'disponibilite_')]
class DisponibiliteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(DisponibiliteRepository $disponibiliteRepository, VehiculeRepository $vehiculeRepository): Response
    {
        $vehicules = $vehiculeRepository->findAllOrderedById();

        return $this->render('disponibilite/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }

    #[Route('/ajouter/{id}', name: 'add')]
    public function add(EntityManagerInterface $em, VehiculeRepository $vehiculeRepository, DisponibiliteRepository $disponibiliteRepository, Request $request, int $id): Response
    {
        $vehicule = $vehiculeRepository->find($id);

        $disponibilite = new Disponibilite();
        $disponibiliteForm = $this->createForm(DisponibiliteType::class, $disponibilite);

        $disponibiliteForm->handleRequest($request);

        if ($disponibiliteForm->isSubmitted() && $disponibiliteForm->isValid()) {

            $dateDebut = $disponibiliteForm->get('date_debut')->getData();
            $dateFin = $disponibiliteForm->get('date_fin')->getData();
            $vehiculeId = $vehicule->getId();

            $disponibilitesExistantes = $disponibiliteRepository->getDisponibilitiesForVehicule($dateDebut, $dateFin, $vehiculeId);

            if ($disponibilitesExistantes) {

                $this->addFlash('error', 'La disponibilité que vous voulez ajouter chevauche une disponibilté existante, choisissez de nouvelles dates');

                return $this->redirectToRoute('disponibilite_index');
            }

            $disponibilite->setVehicule($vehicule);

            $em->persist($disponibilite);
            $em->flush();

            $this->addFlash('success', 'La disponibilité à bien été ajoutée');

            return $this->redirectToRoute('disponibilite_index');
        }


        return $this->render('disponibilite/add.html.twig', [
            'disponibiliteForm' => $disponibiliteForm->createView(),
        ]);
    }

    #[Route('/modifier/{id}', name: 'edit')]
    public function edit(Disponibilite $disponibilite, EntityManagerInterface $em, Request $request, DisponibiliteRepository $disponibiliteRepository): Response
    {
        $disponibiliteForm = $this->createForm(DisponibiliteType::class, $disponibilite);

        $disponibiliteForm->handleRequest($request);

        if ($disponibiliteForm->isSubmitted() && $disponibiliteForm->isValid()) {

            $dateDebut = $disponibiliteForm->get('date_debut')->getData();
            $dateFin = $disponibiliteForm->get('date_fin')->getData();
            $vehicule = $disponibiliteForm->get('vehicule')->getData();
            $vehiculeId = $vehicule->getId();
            $idDisponibiliteCourante = $disponibilite->getId();

            $disponibilitesExistantes = $disponibiliteRepository->getDisponibilitiesForVehicule($dateDebut, $dateFin, $vehiculeId, $idDisponibiliteCourante);

            if ($disponibilitesExistantes) {

                $this->addFlash('error', 'La disponibilité que vous voulez ajouter chevauche une disponibilté existante, choisissez de nouvelles dates');

                return $this->redirectToRoute('disponibilite_index');
            }

            $em->persist($disponibilite);
            $em->flush();

            $this->addFlash('success', 'La disponibilité à bien été modifiée');

            return $this->redirectToRoute('disponibilite_index');
        }

        return $this->render('disponibilite/edit.html.twig', [
            'disponibiliteForm' => $disponibiliteForm->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $em, Disponibilite $disponibilite): Response
    {

        $em->remove($disponibilite);
        $em->flush();

        $this->addFlash('success', 'La disponibilité a bien été supprimée.');

        return $this->redirectToRoute('disponibilite_index');
    }
}
