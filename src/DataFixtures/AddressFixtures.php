<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Department;
use App\Entity\User;
use App\Entity\Baker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // fixtures regarding address information for bakers
        /*
        $baker->setStreetNumber($faker->randomNumber(2, true));
        $baker->setStreetName($faker->streetName());
        $baker->setPostcode($faker->randomNumber(5, true));
        $baker->setCity($faker->city());
        $baker->setDepartment($this // @phpstan-ignore-line
        ->getReference('department_' . $faker->departmentNumber())); // @phpstan-ignore-line

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont BakerFixtures dépend
        return [
            DepartmentFixtures::class,
        ];
    }
    */
    }
}
