<?php

namespace App\Controller\Api;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    #[Route('/api/auteurs', methods: ['GET'])]
    public function index(AuteurRepository $auteurRepository): JsonResponse
    {
        $auteurs = $auteurRepository->findAll();
        return $this->json($auteurs, 200, [], ['groups' => 'auteur:read']);
    }
}