<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Auteur;
use App\Entity\Adherent;
use App\Entity\Categorie;
use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Reservations;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BibliothequeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // création du faker
        $faker = Factory::create('fr_FR');

        // définir le nombre d'entités à créer
        // $roles = ["ROLE_ADHERENT", "ROLE_BIBLIOTHECAIRE", "ROLE_RESPONSABLE"];
        $nombreAdherents = 10;
        $nombreResponsables = 1;
        $nombreBibliothecaires = 2;
        $nombreAuteurs = 12;
        $nombreEmprunts = 10;
        $nombreLivres = 20;
        $nomCategories = ["romans français", "romans étrangers", "essais politiques", "essais économiques"];
        $livresDejaReserves = [];

        // les tableaux qui vont contenir les entités
        $adherents = [];
        $auteurs = [];
        $categories = [];
        $emprunts = [];
        $livres = [];
        $reservations = [];
        $users = [];

        for ($i = 0; $i < $nombreAdherents + $nombreResponsables + $nombreBibliothecaires; $i++) {
            $user = new Utilisateur();
            $user->setEmail($faker->email);
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);
            $user->setDateNaiss($faker->dateTimeBetween('-50 years', '-20 years'));
            $user->setAdressePostale($faker->address);
            $user->setNumTel($faker->phoneNumber);
            $user->setPhoto("https://picsum.photos/300/300");
            $user->setPassword($faker->password);
            
            if ($i < $nombreResponsables) {
                $user->setRoles(["ROLE_RESPONSABLE"]);
            } elseif ($i < $nombreResponsables + $nombreBibliothecaires) {
                $user->setRoles(["ROLE_BIBLIOTHECAIRE"]);
            } else {
                $user->setRoles(["ROLE_ADHERENT"]);
            }
            
            $users[] = $user;
            $manager->persist($user);
        }

        // création des adhérents
        foreach ($users as $user) {
            if (in_array("ROLE_ADHERENT", $user->getRoles())) {
                $adherent = new Adherent();
                $adherent->setDateAdhesion($faker->dateTimeBetween('-5 years', 'now'));
                $adherents[] = $adherent;
                $adherent->setUtilisateur($user);
                $manager->persist($adherent);
            }
        }

        // création des auteurs
        for ($i = 0; $i < $nombreAuteurs; $i++) {
            $auteur = new Auteur();
            $auteur->setNom($faker->lastName);
            $auteur->setPrenom($faker->firstName);
            $auteur->setDateNaissance($faker->dateTimeBetween('-100 years', '-50 years'));
            $auteur->setDateDeces($faker->dateTimeBetween('-50 years', 'now'));
            $auteur->setNationalite($faker->country);
            $auteur->setPhoto("https://picsum.photos/300/300");
            $auteur->setDescription($faker->text);

            $auteurs[] = $auteur;
            $manager->persist($auteur);
        }

        // création des catégories
        for ($i = 0; $i < count($nomCategories); $i++) {
            $categorie = new Categorie();
            $categorie->setNom($nomCategories[$i]);
            $categorie->setDescription($faker->text);

            $categories[] = $categorie;
            $manager->persist($categorie);
        }

        // création des livres
        for ($i = 0; $i < $nombreLivres; $i++) {
            $livre = new Livre();
            $livre->setTitre($faker->sentence(3));
            $livre->setDateSortie($faker->dateTimeBetween('-20 years', 'now'));
            $livre->setLangue($faker->languageCode());
            $livre->setPhotoCouverture("https://picsum.photos/400/600");

            // ajout des auteurs
            $nombreAuteursPourLivre = rand(1, 3);
            $auteursAleatoires = (array)array_rand($auteurs, $nombreAuteursPourLivre);
            foreach ($auteursAleatoires as $index) {
                $livre->addAuteur($auteurs[$index]);
            }

            $livres[] = $livre;
            $manager->persist($livre);
        }

        // création des emprunts
        for ($i = 0; $i < $nombreEmprunts; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($faker->dateTimeBetween('-5 years', 'now'));
            $emprunt->setDateRetour($faker->dateTimeBetween('-5 years', 'now'));
            $emprunt->setCorrespondre($livres[$faker->numberBetween(0, count($livres) - 1)]);
            $emprunt->addRelier($adherents[$faker->numberBetween(0, count($adherents) - 1)]);

            $emprunts[] = $emprunt;
            $manager->persist($emprunt);
        }

        // création des réservations
        foreach ($adherents as $adherent) {
            $nombreReservationsPourAdherent = rand(0, 3);
            for ($j = 0; $j < $nombreReservationsPourAdherent; $j++) {
                // on s'assure que chaque livre ne soit réservé qu'une seule fois
                if (count($livresDejaReserves) >= count($livres)) break;

                // on choisit un livre au hasard qui n'a pas encore été réservé
                $livrePourReservation = null;
                do {
                    $indexLivre = $faker->numberBetween(0, count($livres) - 1);
                    if (!in_array($indexLivre, $livresDejaReserves)) {
                        $livrePourReservation = $livres[$indexLivre];
                        $livresDejaReserves[] = $indexLivre;
                        break;
                    }
                } while (true);
        
                // on crée la réservation
                if ($livrePourReservation !== null) {
                    $reservation = new Reservations();
                    $reservation->setDateResa($faker->dateTimeBetween('-5 years', 'now'));
                    $reservation->setDateResaFin($faker->dateTimeBetween('-5 years', 'now'));
                    $reservation->setFaire($adherent);
                    $reservation->setLier($livrePourReservation);
                
                    $reservations[] = $reservation;
                    $manager->persist($reservation);
                }
            }
        }

        // ajout des catégories aux livres
        foreach ($livres as $livre) {
            $nombreCategoriesPourLivre = rand(1, 3);
            $categoriesAleatoires = (array)array_rand($categories, $nombreCategoriesPourLivre);
            foreach ($categoriesAleatoires as $index) {
                $livre->addCategory($categories[$index]);
            }
            $manager->persist($livre);
        }
        
        // enregistrement des entités
        $manager->flush();
    }
}
