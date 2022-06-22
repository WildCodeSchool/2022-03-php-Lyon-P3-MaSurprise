<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use App\Entity\Baker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\DataFixtures\DepartmentFixtures;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\BakerFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    // creating addresses for Users
    public function load(ObjectManager $manager): void
    {
        for ($n = 1; $n < 4; $n++) {
            $faker = Factory::create('fr_FR');
            // $product = new Product();
            $address = new Address();
            // $manager->persist($product);

            // fixtures regarding address information for addresss
            $address->setStreetNumber($faker->randomNumber(2, true));
            $address->setStreetName($faker->streetName());
            $address->setPostcode($faker->randomNumber(5, true));
            $address->setCity($faker->city());
            $address->setDepartment($this // @phpstan-ignore-line
                ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line
            $billingAddress = $this->getReference('billingAddress_' . $n);
            if ($billingAddress instanceof User) {
                $address->setBillingAddress($billingAddress);
            }
            $manager->persist($address);
        }

        for ($n = 0; $n < 50; $n++) {
            $faker = Factory::create('fr_FR');
            // $product = new Product();
            $address = new Address();

            // fixtures regarding address information for addresss
            $address->setStreetNumber($faker->randomNumber(2, true));
            $address->setStreetName($faker->streetName());
            $address->setPostcode($faker->randomNumber(5, true));
            $address->setCity($faker->city());
            $address->setDepartment($this // @phpstan-ignore-line
                ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line

            $deliveryAddress = $this->getReference('baker_' . $n);
            if ($deliveryAddress instanceof Baker) {
                $address->setDeliveryAddress($deliveryAddress);
            }
            // $manager->persist($product);b
            $manager->persist($address);
        }
        $manager->flush();
    }



    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont addressFixtures dépend
        return [
            DepartmentFixtures::class,
            UserFixtures::class,
            BakerFixtures::class
        ];
    }
}
