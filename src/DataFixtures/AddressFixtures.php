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
        for ($i = 3; $i < 101; $i++) {
            $faker = Factory::create('fr_FR');
            $address = new Address();

            // fixtures regarding address information for addresss
            $address->setStreetNumber($faker->randomNumber(2, true));
            $address->setStreetName($faker->streetName());
            $address->setPostcode($faker->randomNumber(5, true));
            $address->setCity($faker->city());
            $address->setDepartment($this // @phpstan-ignore-line
                ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line
            //$address->setBillingAddress($this->getReference('user_' . $i));
            $this->addReference('billingAddress_' . $i, $address);
            $manager->persist($address);
        }

        for ($j = 3; $j < 51; $j++) {
            $faker = Factory::create('fr_FR');
            $address = new Address();

            // fixtures regarding address information for addresss
            $address->setStreetNumber($faker->randomNumber(2, true));
            $address->setStreetName($faker->streetName());
            $address->setPostcode($faker->randomNumber(5, true));
            $address->setCity($faker->city());
            $address->setDepartment($this // @phpstan-ignore-line
                ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line
            //$address->setDeliveryAddress($this->getReference('user_' . $i . '_baker_' . $i));
            $this->addReference('deliveryAddress_' . $j, $address);
            $manager->persist($address);
        }

        $manager->flush();
    }



    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont addressFixtures dépend
        return [
            DepartmentFixtures::class,
            //UserFixtures::class,
            //BakerFixtures::class
        ];
    }
}
