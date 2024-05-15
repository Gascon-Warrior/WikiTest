<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vehicule', name: 'vehicle_owner_')]
class VehicleOwnerController extends AbstractController
{

    #[Route('/', name: 'add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $vehicule = new Vehicule();
        $vehiculeForm = $this->createForm(VehiculeType::class, $vehicule);

        $vehiculeForm->handleRequest($request);

        if ($vehiculeForm->isSubmitted() && $vehiculeForm->isValid()) {

            $em->persist($vehicule);
            $em->flush();

            $this->addFlash('success', 'Le véhicule a bien été ajouté.');

            return $this->redirectToRoute('disponibilite_index');
        }

        return $this->render('vehicle_owner/add.html.twig', [
            'vehiculeForm' => $vehiculeForm->createView(),
        ]);
    }

    #[Route('/modifier/{id}', name: 'edit')]
    public function edit(Vehicule $vehicule, EntityManagerInterface $em, Request $request): Response
    {
        $vehiculeForm = $this->createForm(VehiculeType::class, $vehicule);

        $vehiculeForm->handleRequest($request);

        if ($vehiculeForm->isSubmitted() && $vehiculeForm->isValid()) {

            $em->persist($vehicule);
            $em->flush();

            $this->addFlash('success', 'Le vehicule à bien été modifié');

            return $this->redirectToRoute('disponibilite_index');
        }

        return $this->render('vehicle_owner/edit.html.twig', [
            'vehiculeForm' => $vehiculeForm->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $em, Vehicule $vehicule): Response
    {

        $em->remove($vehicule);
        $em->flush();

        $this->addFlash('success', 'Le véhicule a bien été supprimé.');

        return $this->redirectToRoute('disponibilite_index');
    }
}
