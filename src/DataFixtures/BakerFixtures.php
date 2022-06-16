<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Baker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BakerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $baker = new Baker();
            $baker->setCreated($faker->dateTime);
            $baker->setLastname($faker->lastName());
            $baker->setFirstname($faker->firstName());
            $commercialName = $faker->optional()->randomElement(
                ['La fée des gâteaux', 'Super Cake', 'Maison Truffe', 'Cakery Lina', 'Chef Alex', 'Gâteau sur commande']
            );
            if (is_string($commercialName)) {
                $baker->setCommercialname($commercialName);
            }
            $baker->setEmail($faker->email());
            $baker->setPassword($faker->password(8, 15));
            $baker->setPhone($faker->phoneNumber());
            $this->addReference('baker_' . $i, $baker);
            // fixtures regarding address information for bakers
            $baker->setStreetNumber($faker->randomNumber(2, true));
            $baker->setStreetName($faker->streetName());
            $baker->setPostcode($faker->randomNumber(5, true));
            $baker->setCity($faker->city());
            $baker->setDepartment($this->getReference('department_' . $faker->departmentNumber()));

            $manager->persist($baker);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont BakerFixtures dépend
        return [
            DepartmentFixtures::class,
        ];
    }
}
