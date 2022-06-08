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
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $cake = new Cake();
            $cake->setCreated($faker->dateTime);
            $cake->setName((string) $faker->randomElement(
                ['Gâteau d\'anniversaire', 'Forêt noire', 'Pièce montée', 'Gâteau licorne',
                'Fraisier', 'Gâteau à étages, crème au beurre', 'Baba au rhum']
            ));
            $cake->setPicture1($faker->imageUrl(640, 640, 'photo d\'un gâteau'));
            $cake->setDescription($faker->text(250));
            $cake->setPrice($faker->randomFloat(2, 50, 300));
            $size = $faker->randomElement((['10/12 parts', '14/16 parts', '18/20 parts']));
            if (is_string($size)) {
                $cake->setSize($size);
            }
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
