<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Baker;

class BakerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 50; $i++) {
            $baker = new Baker();
            $baker->setCreated($faker->dateTime);
            $commercialName = $faker->optional()->randomElement(
                ['La fée des gâteaux', 'Super Cake', 'Maison Truffe', 'Cakery Lina', 'Chef Alex', 'Gâteau sur commande']
            );
            if (is_string($commercialName)) {
                $baker->setCommercialname($commercialName);
            }
            $bakerType = $faker->randomElement(['professionnel', 'amateur']);
            if (is_string($bakerType)) {
                $baker->setBakerType($bakerType);
            }
            $baker->setDeliveryAddress($faker->address());
            $baker->setUser($this->getReference('user_' . $i));
            $this->addReference('baker_' . $i, $baker);
            $manager->persist($baker);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                UserFixtures::class,
            ];
    }
}
