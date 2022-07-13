<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderLineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $randomBakerRef = rand(0, 19);
            for ($j = 0; $j < rand(1, 3); $j++) {
                $orderLine = new OrderLine();
                $name = $faker->randomElement([
                    'Forêt noire',
                    'Pièce montée au caramel et fruits rouges',
                    'Gâteau licorne',
                    'Gâteau d\'anniversaire Peppa Pig',
                    'Entremets aux fruits',
                    'Saint-Pothin',
                    'Tarte aux framboises',
                    'Mille-feuilles à la crème pâtissière',
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
                if ($this->getReference('deliveryAddress_' . $i) instanceof Address) {
                    $orderLine->setDeliveryAddress($this->getReference('deliveryAddress_' . $i));
                }
                $seller = $this->getReference('seller_' . $randomBakerRef);
                if ($seller instanceof User) {
                    $orderLine->setSeller($seller);
                };
                if ($this->getReference('order_' . $i) instanceof Order) {
                    $orderLine->setOrderReference($this->getReference('order_' . $i));
                }
                $orderLine
                    ->setCakePrice($faker->randomFloat(2, 50, 200))
                    ->setQuantity($faker->numberBetween(1, 3));
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
