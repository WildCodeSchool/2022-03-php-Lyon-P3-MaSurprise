<?php

namespace App\DataFixtures;

use App\Entity\Address;
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

        for ($i = 0; $i < 100; $i++) {
            $order = new Order();
            $order
                ->setOrderedAt($faker->dateTimeInInterval('-1 week', '+6 days'))
                ->setOrderStatus(strval($faker->randomElement([
                    'Commande créée',
                    'Commande validée',
                    'Commande en préparation',
                    'Commande disponible en retrait',
                    'Commande retirée',
                    'Commande terminée',
                    'Commande annulée',
                ])))
                ->setCollectDate($faker->dateTimeInInterval('+3 months', '+1 months'));
            $buyer = $this->getReference('buyer_' . $faker->numberBetween(20, 50));
            if ($buyer instanceof User) {
                $order->setBuyer($buyer);
            };
            $order->setTotal($faker->randomFloat(2, 12, 50));
            $order->setNumber(
                rand(1, 9) .
                strtoupper(substr($faker->lastName(), 0, 2)) .
                rand(1000, 9999) .
                substr(strval(floor(microtime(true) * 1000)), -6)
            );
            if ($this->getReference('billingAddress_' . $i) instanceof Address) {
                $order->setBillingAddress($this->getReference('billingAddress_' . $i));
            }
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
