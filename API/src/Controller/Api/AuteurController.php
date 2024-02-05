<?php

namespace App\Controller\Api;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTimeImmutable;

class AuteurController extends AbstractController
{
    #[Route('/api/auteurs', methods: ['GET'])]
    public function index(AuteurRepository $auteurRepository): JsonResponse
    {
        $auteurs = $auteurRepository->findAll();
        return $this->json($auteurs, 200, [], ['groups' => 'auteur:read']);
    }

    #[Route('/api/auteur', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $auteur = new Auteur();
        $auteur->setNom($data['Nom']);
        $auteur->setPrenom($data['Prenom']);
        $dateNaissance = new DateTimeImmutable($data['DateNaissance']);
        $auteur->setDateNaissance($dateNaissance);

        if (!empty($data['DateDeces'])) {
            $dateDeces = new DateTimeImmutable($data['DateDeces']);
            $auteur->setDateDeces($dateDeces);
        }
        
        $auteur->setNationalite($data['Nationalite']);
        $auteur->setPhoto($data['Photo']);
        $auteur->setDescription($data['Description']);
        
        $date = new DateTimeImmutable("now");
        $auteur->setCreatedAt($date);
        $auteur->setUpdatedAt($date);

        $entityManager->persist($auteur);
        $entityManager->flush();

        return $this->json($auteur, JsonResponse::HTTP_CREATED);
    }
}
