<?php

namespace App\Controller\Api;

use App\Repository\ReservationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{

    #[Route('/api/reservations', methods: ['GET'])]
    public function index(ReservationsRepository $reservationRepository): JsonResponse
    {
        $reservations = $reservationRepository->findAll();
        return $this->json($reservations, 200, [], ['groups' => 'reservation:read']);
    }
}
