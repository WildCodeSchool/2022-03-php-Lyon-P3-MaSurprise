<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 1000; $i++) {
            $order = new Order();
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
            $order
                ->setOrderedAt($faker->dateTimeInInterval('+2 months', '+1 months'))
                ->setOrderStatus($faker->randomElement([
                    'Commande créée',
                    'Commande validée',
                    'Commande en préparation',
                    'Commande disponible en retrait',
                    'Commande retirée',
                    'Commande terminée',
                    'Commande annulée',
                ]))
                ->setStreetNumber($faker->randomNumber(2, true))
                ->setStreetName($faker->streetName())
                ->setPostcode($faker->randomNumber(5, true))
                ->setCity($faker->city())
                ->setDepartment(strval($faker->randomNumber(2, true)))
                ->setCakePrice($faker->randomFloat(2, 50, 300))
                ->setCollectDate($faker->dateTimeInInterval('+3 months', '+1 months'));
            $buyer = $this->getReference('buyer_' . $faker->numberBetween(50, 150));
            if ($buyer instanceof User) {
                $order->setBuyer($buyer);
            };
            $seller = $this->getReference('seller_' . $faker->numberBetween(0, 49));
            if ($seller instanceof User) {
                $order->setSeller($seller);
            };
            $order
                ->setOrderValidated($faker->boolean());
            $this->addReference('order_' . $i, $order);
            $manager->persist($order);
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
