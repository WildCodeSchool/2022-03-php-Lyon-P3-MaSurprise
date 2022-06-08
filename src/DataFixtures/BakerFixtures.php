<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Baker;

class BakerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 15; $i++) {
            $baker = new Baker();
            $baker->setCreated($faker->dateTime);
            $baker->setLastname($faker->lastName());
            $baker->setFirstname($faker->firstName());
            $baker->setCommercialname($faker->optional()->randomElement(
                ['La fée des gâteaux', 'Super Cake', 'Maison Truffe', 'Cakery Lina', 'Chef Alex', 'Gâteau sur commande']
            ));
            $baker->setEmail($faker->email());
            $baker->setPassword($faker->password(8, 15));
            $baker->setPhone($faker->phoneNumber());
            $this->addReference('baker_' . $i, $baker);
            $manager->persist($baker);
        }
        $manager->flush();
    }
}
