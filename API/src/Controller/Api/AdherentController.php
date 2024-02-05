<?php

namespace App\Controller\Api;

use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdherentController extends AbstractController
{
    #[Route('/api/adherents', methods: ['GET'])]
    public function index(AdherentRepository $adherentRepository): JsonResponse
    {
        $adherents = $adherentRepository->findAll();
        return $this->json($adherents, 200, [], ['groups' => 'adherent:read']);
    }

    /*
    #[Route('/api/adherent', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // version simplifiée qui ne gère pas la catégorie ni la date
        $data = json_decode($request->getContent(), true);
        $adherent = new Adherent();
        $adherent->setTitre($data['titre']);
        $adherent->setDescription($data['description']);
        $entityManager->persist($adherent);
        $entityManager->flush();

        return $this->json($adherent, JsonResponse::HTTP_CREATED);
    }
    */
}
