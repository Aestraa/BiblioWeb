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
        // Récupérer le paramètre de requête 'query'
        $choix = '';
        $query = $request->query->get('categorie');
        $choix = 'categorie';

        if ($query === null) {
            $query = $request->query->get('auteur');
            $choix = 'auteur';
        }
        if ($query === null) {
            $query = $request->query->get('date_sortie');
            $choix = 'date_sortie';
        }
        if ($query === null) {
            $query = $request->query->get('langue');
            $choix = 'langue';
        }
        if ($query === null) {
            $query = $request->query->get('titre');
            $choix = 'titre';
        }

        if ($query === null) {
            return $this->json(['message' => 'Aucun paramètre de recherche fourni.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérifier si la variable est une autre propriété

        // Appeler la méthode correspondante en fonction de la propriété
        switch ($choix) {
            case 'categorie':
                $livres = $livreRepository->findByCategory($query);
                break;
            case 'auteur':
                // Diviser la chaîne en nom et prénom
                $parts = explode(' ', $query);
                $nom = $parts[0];
                $prenom = isset($parts[1]) ? $parts[1] : '';
                $livres = $livreRepository->findByAuthor($nom, $prenom);
                break;
            case 'date_sortie':
                $livres = $livreRepository->findByCreationDate($query);
                break;
            case 'langue':
                $livres = $livreRepository->findByNationality($query);
                break;
            case 'titre':
                $livres = $livreRepository->findByPartialTitle($query);
                break;
            default:
                return $this->json(['message' => 'Propriété de recherche invalide.','query' => $query,'choix' => $choix], JsonResponse::HTTP_BAD_REQUEST);
        }

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
