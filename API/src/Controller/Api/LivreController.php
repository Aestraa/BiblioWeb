<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\Livre;
use App\Entity\Auteur;
use DateTimeImmutable;
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
        return $this->json($livres, JsonResponse::HTTP_OK, [], ['groups' => 'livre:read']);
    }

    #[Route('/api/livre/search', methods: ['GET'])]
    public function searchBy(Request $request, LivreRepository $livreRepository): JsonResponse
    {

        // Récupérer les paramètres de recherche de la requête
        $categorie = $request->query->get('categorie');
        $titre = $request->query->get('titre');
        $auteurNom = $request->query->get('auteur_nom');
        $auteurPrenom = $request->query->get('auteur_prenom');
        $dateSortie = $request->query->get('date_sortie');
        $dateSortie = $dateSortie ? new DateTime($dateSortie) : null;
        $langue = $request->query->get('langue');

        // Effectuer la recherche en utilisant les paramètres fournis
        $livres = $livreRepository->findByMultipleCriteria($categorie, $titre, $auteurNom, $auteurPrenom, $dateSortie, $langue);
        
        return $this->json($livres, JsonResponse::HTTP_OK, [], ['groups' => 'livre:read']);
    }
  
    #[Route('/api/livre/{id}', methods: ['GET'])]
    public function show(int $id, LivreRepository $livreRepository): JsonResponse
    {
        $livre = $livreRepository->find($id);

        if (!$livre) {
            return $this->json(['message' => 'Livre not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($livre, JsonResponse::HTTP_OK, [], ['groups' => 'livre:read']);
    }

    #[Route('/api/livre', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $livre = new Livre();
        $livre->setTitre($data['Titre']);
        $livre->setDateSortie(new DateTime($data['DateSortie']));
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

        return $this->json($livre, JsonResponse::HTTP_CREATED, ['groups' => 'livre:read']);
    }
}
