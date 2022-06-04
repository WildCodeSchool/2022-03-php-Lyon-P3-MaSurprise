<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Cake;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CakeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $cake = new Cake();
            $cake->setCreated($faker->dateTime);
            $cake->setName($faker->words(3, true));
            $cake->setPicture1('cake picture');
            $cake->setDescription($faker->paragraphs(2, true));
            $cake->setPrice($faker->randomFloat(2, 50, 300));
            $cake->setSize('small');
            $cake->setBaker($this->getReference('baker_' . $faker->numberBetween(1, 9)));
            $manager->persist($cake);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return
        [
            BakerFixtures::class,
        ];
    }
}
