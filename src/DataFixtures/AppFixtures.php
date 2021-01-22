<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Personne;
use App\Entity\Cadeau;
use App\Entity\Adresse;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 3; $i++)
        {
            $categorie = new Categorie();
            $categorie->setNom($faker->sentence());

            $manager->persist($categorie);

            for($j = 1; $j <= 5; $j++)
            {
                    $adresse = new Adresse();
                    $adresse->setNumRue($faker->numberBetween($min = 1, $max = 250))
                            ->setRue($faker->streetName)
                            ->setCodePost($faker->numberBetween($min = 10000, $max = 99999))
                            ->setVille($faker->city);


                    $personne = new Personne();
                    $personne->setNomPrenom($faker->name)
                             ->setSexe("autre")
                             ->setDateNais($faker->dateTime)
                             ->setAdresse($adresse);

                    $manager->persist($adresse);
                    $manager->persist($personne);

                for($y = 1; $y <= 3; $y++)
                {
                    $cadeau = new Cadeau();
                    $cadeau->setDesignation($faker->sentence())
                           ->setAgeMin($faker->numberBetween($min = 0, $max = 18))
                           ->setPrixMoyen($faker->numberBetween($min = 1, $max = 250))
                           ->setCategorie($categorie);
                    
                    $manager->persist($cadeau);

                    $personne->addSouhait($cadeau);
                }

                
            }
        }

        $manager->flush();
    }
}
