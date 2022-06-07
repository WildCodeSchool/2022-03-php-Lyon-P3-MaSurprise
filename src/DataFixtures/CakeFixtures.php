<?php

namespace App\DataFixtures;

use App\Entity\Baker;
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
            $cake->setName($faker->text(25));
            $cake->setPicture1('cake picture');
            $cake->setDescription($faker->text(250));
            $cake->setPrice($faker->randomFloat(2, 50, 300));
            $cake->setSize('small');

            $baker = $this->getReference('baker_' . $faker->numberBetween(1, 9));
            if ($baker instanceof Baker) {
                $cake->setBaker($baker);
            }
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
