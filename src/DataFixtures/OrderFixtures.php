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

        for ($i = 0; $i < 200; $i++) {
            $order = new Order();
            $order
                ->setOrderedAt($faker->dateTimeInInterval('-1 week', '+6 days'))
                ->setOrderStatus($faker->randomElement([
                    'Commande créée',
                    'Commande validée',
                    'Commande en préparation',
                    'Commande disponible en retrait',
                    'Commande retirée',
                    'Commande terminée',
                    'Commande annulée',
                ]))
                ->setCollectDate($faker->dateTimeInInterval('+3 months', '+1 months'));
            $buyer = $this->getReference('buyer_' . $faker->numberBetween(50, 150));
            if ($buyer instanceof User) {
                $order->setBuyer($buyer);
            };
            $order->setTotal($faker->numberBetween(250, 450));
            if ($this->getReference('billingAddress_' . $i) instanceof Address) {
                $order->setBillingAddress($this->getReference('billingAddress_' . $i));
            }
            if ($this->getReference('deliveryAddress_' . $i) instanceof Address) {
                $order->setDeliveryAddress($this->getReference('deliveryAddress_' . $i));
            }
            $seller = $this->getReference('seller_' . $faker->numberBetween(0, 49));
            if ($seller instanceof User) {
                $order->setSeller($seller);
            };
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
