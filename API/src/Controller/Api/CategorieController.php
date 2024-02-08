<?php

namespace App\Controller\Api;

use DateTimeImmutable;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/api/categories', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): JsonResponse
    {
        $categories = $categorieRepository->findAll();
        return $this->json($categories, 200, [], ['groups' => 'categorie:read']);
    }

    #[Route('/api/categorie', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $categorie = new Categorie();
        $categorie->setNom($data['Nom']);
        $categorie->setDescription($data['Description']);

        $date = new DateTimeImmutable("now");
        $categorie->setCreatedAt($date);
        $categorie->setUpdatedAt($date);

        $entityManager->persist($categorie);
        $entityManager->flush();

        return $this->json($categorie, JsonResponse::HTTP_CREATED, [], ['groups' => 'categorie:read']);
    }
}
