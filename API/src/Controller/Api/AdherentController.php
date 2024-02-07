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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdherentController extends AbstractController
{
    
    #[Route('/api/adherents', methods: ['GET'])]
    public function index(AdherentRepository $adherentRepository): JsonResponse
    {
        $adherents = $adherentRepository->findAll();
        return $this->json($adherents, 200, [], ['groups' => 'adherent:read']);
    }
    

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    //put pour modif
    #[Route('/api/adherent/modif/{id}', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager, Adherent $adherent): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Mise à jour des informations de l'utilisateur lié à l'adhérent
        $utilisateur = $adherent->getUtilisateur();
        $utilisateur->setEmail($data['Email']);
        $utilisateur->setNom($data['Nom']);
        $utilisateur->setPrenom($data['Prenom']);
        $dateNaiss = new DateTime($data['DateNaiss']);
        $utilisateur->setDateNaiss($dateNaiss);
        $utilisateur->setAdressePostale($data['AdressePostale']);
        $utilisateur->setNumTel($data['NumTel']);
        $utilisateur->setPhoto($data['Photo']);
        //mise à jour du mot de passe si nécessaire

        // Mise à jour de la date de modification
        $utilisateur->setUpdatedAt(new DateTimeImmutable("now"));

        // Mise à jour de la date d'adhésion de l'adhérent
        $adherent->setDateAdhesion(new DateTimeImmutable("now"));

        $entityManager->flush();

        return $this->json($adherent, JsonResponse::HTTP_OK);
    }

    //get adherent précis // pas d'authentification
    #[Route('/api/adherent/{id}', methods: ['GET'])]
    public function getById(Adherent $adherent): JsonResponse
    {
        // Vous pouvez accéder directement à l'adhérent grâce à l'injection de dépendances
        // Symfony chargera l'adhérent correspondant à l'ID passé dans l'URL

        // Vérifiez si l'adhérent existe
        if (!$adherent) {
            return $this->json(['message' => 'Adhérent non trouvé.'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retournez l'adhérent en tant que réponse JSON
        return $this->json($adherent, JsonResponse::HTTP_OK, [], ['groups' => 'adherent:read']);
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

        $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $data['Password']);
        $utilisateur->setPassword($hashedPassword);

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

        return $this->json($adherent, JsonResponse::HTTP_CREATED, [], ['groups' => 'adherent:read']);
    }
}
