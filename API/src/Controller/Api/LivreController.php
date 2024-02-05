<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\Livre;
use App\Entity\Auteur;
use DateTimeImmutable;
use DateTimeInterface;
use App\Entity\Categorie;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreController extends AbstractController
{

    #[Route('/api/livres', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): JsonResponse
    {
        $livres = $livreRepository->findAll();
        return $this->json($livres, 200, [], ['groups' => 'livre:read']);
    }

    #[Route('/api/livre', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $livre = new Livre();
        $livre->setTitre($data['Titre']);
        $dateSortie = new DateTime($data['DateSortie']);
        $livre->setDateSortie($dateSortie);
        $livre->setLangue($data['Langue']);
        $livre->setPhotoCouverture($data['PhotoCouverture']);

        foreach ($data['Auteur'] as $auteurId) {
            $auteur = $entityManager->getReference(Auteur::class, $auteurId);
            $livre->addAuteur($auteur);
        }
    
        foreach ($data['Categorie'] as $categorieId) {
            $categorie = $entityManager->getReference(Categorie::class, $categorieId);
            $livre->addCategory($categorie);
        }

        $livre->setCreatedAt(new DateTimeImmutable("now"));
        $livre->setUpdatedAt(new DateTimeImmutable("now"));

        $entityManager->persist($livre);
        $entityManager->flush();
        
        return $this->json($livre, JsonResponse::HTTP_CREATED,['groups' => 'emprunt:write']);
    }
}
