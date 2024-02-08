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
    #[Route('/api/adherent/modif', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = $this->getUser();
        if (!$utilisateur instanceof Utilisateur) {
            throw new \LogicException('L\'objet User n\'est pas de la classe attendue ou est null.');
        }
        $adherent = $utilisateur->getEst();

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

        // Mise à jour de la date de modification
        $utilisateur->setUpdatedAt(new DateTimeImmutable("now"));

        $entityManager->flush();

        return $this->json($adherent, JsonResponse::HTTP_OK , [], ['groups' => 'adherent:read']);
    }

    //get adherent précis // pas d'authentification
    #[Route('/api/adherent', methods: ['GET'])]
    public function getById(Request $request): JsonResponse
    {
        // Vous pouvez accéder directement à l'adhérent grâce à l'injection de dépendances
        // recherche avec le token
        $user = $this->getUser();
        if (!$user instanceof Utilisateur) {
            throw new \LogicException('L\'objet User n\'est pas de la classe attendue ou est null.');
        }
        $adherent = $user->getEst();

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
        $utilisateur->setEmail($data['email']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
        $dateNaiss = new DateTime($data['dateNaiss']);
        $utilisateur->setDateNaiss($dateNaiss);
        $utilisateur->setAdressePostale($data['adressePostale']);
        $utilisateur->setNumTel($data['numTel']);
        $utilisateur->setPhoto('');
        $utilisateur->addRoles('ROLE_ADHERENT');

        $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $data['password']);
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
