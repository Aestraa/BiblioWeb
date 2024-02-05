<?php

namespace App\Controller\Api;

use DateTime;
use DateInterval;
use App\Entity\Livre;
use DateTimeImmutable;
use App\Entity\Emprunt;
use App\Entity\Adherent;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmpruntController extends AbstractController
{
    #[Route('/api/emprunts', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): JsonResponse
    {
        $emprunts = $empruntRepository->findAll();
        return $this->json($emprunts, 200, [], ['groups' => 'emprunt:read']);
    }

    #[Route('/api/emprunt', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $emprunt = new Emprunt();
        $emprunt->setDateEmprunt(new DateTimeImmutable("now"));

        $dateRetour = new DateTimeImmutable("now");
        $dateRetour->add(new DateInterval('P7D'));
        $emprunt->setDateRetour($dateRetour);
        
        $emprunt->setCorrespondre($entityManager->getReference(Livre::class, $data['Livre']));
        $emprunt->addRelier($entityManager->getReference(Adherent::class, $data['Adherent']));

        $emprunt->setCreatedAt(new DateTimeImmutable("now"));
        $emprunt->setUpdatedAt(new DateTimeImmutable("now"));

        $entityManager->persist($emprunt);
        $entityManager->flush();
        
        return $this->json($emprunt, JsonResponse::HTTP_CREATED,['groups' => 'emprunt:write']);
    }
}
