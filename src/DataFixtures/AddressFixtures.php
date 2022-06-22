<?php

namespace App\DataFixtures;

use App\Entity\Address;
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

            $address->setBillingAddress($this->getReference('billingAddress_' . $n));

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

            $address->setDeliveryAddress($this->getReference('baker_' . $n));

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
