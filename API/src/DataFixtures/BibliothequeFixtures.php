<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Auteur;
use App\Entity\Adherent;
use App\Entity\Categorie;
use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Reservations;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BibliothequeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $nombreAdherents = 10;
        $nombreAuteurs = 12;
        $nombreEmprunts = 10;
        $nombreLivres = 20;
        $nombreReservations = 10;
        $nomCategories = ["romans français", "romans étrangers", "essais politiques", "essais économiques"];

        $adherents = [];
        $auteurs = [];
        $categories = [];
        $emprunts = [];
        $livres = [];
        $reservations = [];

        for ($i = 0; $i < $nombreAdherents; $i++) {
            $adherent = new Adherent();
            $adherent->setDateAdhesion($faker->dateTimeBetween('-5 years', 'now'));
            $adherent->setNom($faker->lastName);
            $adherent->setPrenom($faker->firstName);
            $adherent->setDateNaiss($faker->dateTimeBetween('-50 years', '-20 years'));
            $adherent->setEmail($faker->email);
            $adherent->setAdressePostale($faker->address);
            $adherent->setNumTel($faker->phoneNumber);
            $adherent->setPhoto("https://picsum.photos/300/300");

            $adherents[] = $adherent;
            $manager->persist($adherent);
            $manager->flush();
        }

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
            $manager->flush();
        }

        for ($i = 0; $i < count($nomCategories); $i++) {
            $categorie = new Categorie();
            $categorie->setNom($nomCategories[$i]);
            $categorie->setDescription($faker->text);

            $categories[] = $categorie;
            $manager->persist($categorie);
            $manager->flush();
        }

        for ($i = 0; $i < $nombreLivres; $i++) {
            $livre = new Livre();
            $livre->setTitre($faker->sentence(3));
            $livre->setDateSortie($faker->dateTimeBetween('-20 years', 'now'));
            $livre->setLangue($faker->languageCode());
            $livre->setPhotoCouverture("https://picsum.photos/400/600");
        }

        for ($i = 0; $i < $nombreEmprunts; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($faker->dateTimeBetween('-5 years', 'now'));
            $emprunt->setDateRetour($faker->dateTimeBetween('-5 years', 'now'));
            $emprunt->setCorrespondre($livres[$faker->numberBetween(0, count($livres) - 1)]);
            $emprunt->addRelier($adherents[$faker->numberBetween(0, count($adherents) - 1)]);

            $emprunts[] = $emprunt;
            $manager->persist($emprunt);
            $manager->flush();
        }

        for ($i = 0; $i < $nombreReservations; $i++) {
            $reservation = new Reservations();
            $reservation->setDateResa($faker->dateTimeBetween('-5 years', 'now'));
            $reservation->setFaire($adherents[$faker->numberBetween(0, count($adherents) - 1)]);
            $reservation->setLier($livres[$faker->numberBetween(0, count($livres) - 1)]);

            $reservations[] = $reservation;
            $manager->persist($reservation);
            $manager->flush();
        }

    }
}
