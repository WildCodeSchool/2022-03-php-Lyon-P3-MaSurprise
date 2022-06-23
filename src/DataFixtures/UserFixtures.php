<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail($faker->email());
        $user->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            "password"
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles(['ROLE_BAKER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                "password"
            );
            $user->setPassword($hashedPassword);
            $this->addReference('seller_' . $i, $user);
            $manager->persist($user);
        }

        for ($j = 0; $j < 50; $j++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles(['ROLE_CUSTOMER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'password'
            );
            $user->setPassword($hashedPassword);
            $this->addReference('buyer_' . $j, $user);
            $this->addReference('billingAddress_' . $j, $user);
            $manager->persist($user);
        }
        // Sauvegarde des 3 nouveaux utilisateurs :
        $manager->flush();
    }
}
