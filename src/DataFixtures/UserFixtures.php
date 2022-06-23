<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USERS = [
        [
            'email' => 'customer@gmail.com',
            "roles" => ["ROLE_CUSTOMER"],
            "password" => 'customerpassword',
        ],
        [
            'email' => 'baker@gmail.com',
            'roles' => ['ROLE_BAKER'],
            'password' => 'bakerpassword',
        ],
        [
            'email' => 'admin@monsite.com',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'adminpassword',
        ],
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
//        foreach (self::USERS as $userName) {
//            $user = new User();
//            $user->setEmail($userName['email']);
//            $user->setRoles($userName['roles']);
//            $hashedPassword = $this->passwordHasher->hashPassword(
//                $user,
//                $userName['password']
//            );
//            $user->setPassword($hashedPassword);
//            $manager->persist($user);
//        }

        $faker = Factory::create('fr_FR');

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
            $manager->persist($user);
        }

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
