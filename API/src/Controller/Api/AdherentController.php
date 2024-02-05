<?php

namespace App\Controller\Api;

use DateTime;
use DateTimeImmutable;
use App\Entity\Adherent;
use App\Entity\Utilisateur;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdherentController extends AbstractController
{
    #[Route('/api/adherents', methods: ['GET'])]
    public function index(AdherentRepository $adherentRepository): JsonResponse
    {
        $adherents = $adherentRepository->findAll();
        return $this->json($adherents, 200, [], ['groups' => 'adherent:read']);
    }

    
    #[Route('/api/adherent', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = new Utilisateur();
        $utilisateur->setEmail($data['Email']);
        $utilisateur->setNom($data['Nom']);
        $utilisateur->setPrenom($data['Prenom']);
        $dateNaiss = new DateTime($data['DateNaiss']);
        $utilisateur->setDateNaiss($dateNaiss);
        $utilisateur->setAdressePostale($data['AdressePostale']);
        $utilisateur->setNumTel($data['NumTel']);
        $utilisateur->setPhoto($data['Photo']);
        $utilisateur->addRoles('ROLE_ADHERENT');
        $utilisateur->setPassword($data['Password']);

        $date = new DateTimeImmutable("now");
        $utilisateur->setCreatedAt($date);
        $utilisateur->setUpdatedAt($date);

        $adherent = new Adherent();
        $dateAdhesion = new DateTimeImmutable("now");
        $adherent->setDateAdhesion($dateAdhesion);

        $adherent->setUtilisateur($utilisateur);

        $entityManager->persist($utilisateur);
        $entityManager->persist($adherent);
        $entityManager->flush();

        return $this->json($adherent, JsonResponse::HTTP_CREATED);
    }

}
