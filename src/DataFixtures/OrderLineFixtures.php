<?php

namespace App\DataFixtures;

use App\Entity\OrderLine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderLineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 400; $i++) {
            for ($j = 0; $j < rand(1, 3); $j++) {
                $orderLine = new OrderLine();
                $name = $faker->randomElement([
                    'Gâteau d\'anniversaire',
                    'Forêt noire',
                    'Pièce montée',
                    'Gâteau licorne',
                    'Fraisier',
                    'Gâteau à étages, crème au beurre',
                    'Baba au rhum',
                    'Gâteau au twix, mars et coulis de kinder surprise',
                ]);
                if (is_string($name)) {
                    $orderLine->setCakeName($name);
                };
                $size = $faker->randomElement(([
                    '10/12 parts',
                    '14/16 parts',
                    '18/20 parts',
                ]));
                if (is_string($size)) {
                    $orderLine->setCakeSize($size);
                };
                $orderLine
                    ->setCakePrice($faker->randomFloat(2, 50, 200))
                    ->setQuantity($faker->numberBetween(1, 3))
                    ->setOrderReference($this->getReference('order_' . $i));
                $this->addReference('order' . $i . 'orderLine_' . $j, $orderLine);
                $manager->persist($orderLine);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                OrderFixtures::class,
            ];
    }
}
