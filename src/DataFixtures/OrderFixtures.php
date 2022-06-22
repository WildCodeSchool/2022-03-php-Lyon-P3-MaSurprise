<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $order = new Order();
            $order->setOrderedAt($faker->dateTimeInInterval('+2 months', '+1 months'));
            $order->setOrderStatus($faker->randomElement([
                'Commande créée',
                'Commande validée',
                'Commande en préparation',
                'Commande disponible en retrait',
                'Commande retirée',
                'Commande terminée',
            ]));
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
                $order->setCakeName($name);
            };
            $size = $faker->randomElement(([
                '10/12 parts',
                '14/16 parts',
                '18/20 parts',
            ]));
            if (is_string($size)) {
                $order->setCakeSize($size);
            };
            $order->setStreetNumber($faker->randomNumber(2, true));
            $order->setStreetName($faker->streetName());
            $order->setPostcode($faker->randomNumber(5, true));
            $order->setCity($faker->city());
            $order->setDepartment(strval($faker->randomNumber(2, true)));
//        $order->setDepartment($this // @phpstan-ignore-line
//        ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line
            $order->setCakePrice($faker->randomFloat(2, 50, 300));
            $order->setCollectDate($faker->dateTimeInInterval('+3 months', '+1 months'));
            $order->setOrderValidated($faker->boolean());
            $manager->persist($order);
        }
        $manager->flush();
    }

//    public function getDependencies(): array
//    {
//        return
//            [
//                DepartmentFixtures::class,
//            ];
//    }
}
