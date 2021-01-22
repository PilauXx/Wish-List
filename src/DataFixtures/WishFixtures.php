<?php

namespace App\DataFixtures;

use Doctrine\Bundle\Fixturesbundle\Fixture;
use Doctrine\Common\Persistance\ObjectManager;
use App\Entity\Categorie;
use Faker;
use Faker\Factory;


class WishFixtures extends Fixtures
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
                    $adresse->setNum_rue($faker->numberBetween($min = 1, $max = 250))
                            ->setRue($faker->streetName)
                            ->setCode_post($faker->postcode)
                            ->setVille($faker->city);


                    $personne = new Personne();
                    $personne->setNom_Prenom($faker->name)
                             ->setSexe("autre")
                             ->setDate_nais($faker->dateBetween('-100 years'))
                             ->setAdresse($adresse);

                    $manager->persist($adresse);
                    $manager->persist($personne);

                for($y = 1; $y <= 3; $y++)
                {
                    $cadeau = new Cadeau();
                    $cadeau->setDesignation($faker->sentence())
                           ->setAge_min($faker->numberBetween($min = 0, $max = 18))
                           ->setPrix_moyen($faker->numberBetween($min = 1, $max = 250))
                           ->setCategorie($categorie);
                    
                    $manager->persist($cadeau);

                    $personne->addSouhaits($cadeau);
                }

                
            }
        }

        $manager->flush();
    }
}