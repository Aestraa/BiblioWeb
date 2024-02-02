<?php

namespace App\Controller\Api;

use App\Repository\AdherentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdherentController extends AbstractController
{
    #[Route('/api/adherents', methods: ['GET'])]
    public function index(AdherentRepository $adherentRepository): JsonResponse
    {
        $adherents = $adherentRepository->findAll();
        return $this->json($adherents);
    }
}
