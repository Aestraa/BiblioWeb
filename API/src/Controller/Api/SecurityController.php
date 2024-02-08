<?php

namespace App\Controller\Api;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class SecurityController extends AbstractController
{

    #[Route('/api/login', name:"api_login" ,methods: ['POST'])]
    public function login(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordHasherInterface $passwordEncoder, JWTTokenManagerInterface $jwtManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        $utilisateur = $utilisateurRepository->findOneBy(['email' => $email]);

        // Vérification de l'utilisateur
        if (!$utilisateur) {
            return $this->json(['message' => 'Utilisateur non trouvé.'], Response::HTTP_UNAUTHORIZED);
        }

        // Vérification du mot de passe
        if (!$passwordEncoder->isPasswordValid($utilisateur, $password)) {
            return $this->json(['message' => 'Mot de passe incorrect.'], Response::HTTP_UNAUTHORIZED);
        }
        
        $payload = [
            'id' => $utilisateur->getId(),
        ];
    
        // Création du token JWT avec le payload
        $token = $jwtManager->createFromPayload($utilisateur, $payload);

        // Retourner le token JWT dans la réponse
        return $this->json(['token' => $token]);
    }
}
