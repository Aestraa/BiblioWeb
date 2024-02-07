<?php

namespace App\Controller\Api;

use DateTime;
use DateInterval;
use App\Entity\Livre;
use DateTimeImmutable;
use App\Entity\Adherent;
use App\Entity\Reservations;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationsController extends AbstractController
{

    #[Route('/api/reservations', methods: ['GET'])]
    public function index(ReservationsRepository $reservationRepository): JsonResponse
    {
        $reservations = $reservationRepository->findAll();
        return $this->json($reservations, 200, [], ['groups' => 'reservation:read']);
    }

    #[Route('/api/reservation', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $reservation = new Reservations();

        $reservation->setDateResa(new DateTime("now"));

        $dateRetour = new DateTime("now");
        $dateRetour->add(new DateInterval('P7D'));
        $reservation->setDateResaFin($dateRetour);

        $reservation->setLier($entityManager->getReference(Livre::class, $data['Livre']));
        $reservation->setFaire($entityManager->getReference(Adherent::class, $data['Adherent']));

        $reservation->setCreatedAt(new DateTimeImmutable("now"));
        $reservation->setUpdatedAt(new DateTimeImmutable("now"));

        $entityManager->persist($reservation);
        $entityManager->flush();
        
        return $this->json($reservation, JsonResponse::HTTP_CREATED,['groups' => 'reservation:write']);
    }
}
