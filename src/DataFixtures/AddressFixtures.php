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
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 400; $i++) {
            $address = new Address();

            $address->setStreetNumber($faker->randomNumber(2, true));
            $address->setStreetName($faker->streetName());
            $address->setPostcode($faker->randomNumber(5, true));
            $address->setCity($faker->city());
            $address->setDepartment($this // @phpstan-ignore-line
            ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line
            $this->addReference('billingAddress_' . $i, $address);
            $manager->persist($address);
        }

        for ($j = 0; $j < 400; $j++) {
            $address = new Address();

            $address->setStreetNumber($faker->randomNumber(2, true));
            $address->setStreetName($faker->streetName());
            $address->setPostcode($faker->randomNumber(5, true));
            $address->setCity($faker->city());
            $address->setDepartment($this // @phpstan-ignore-line
            ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line
            $this->addReference('deliveryAddress_' . $j, $address);
            $manager->persist($address);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            DepartmentFixtures::class,
        ];
    }
}
