<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USERS = [
        [
            'email' => 'customer@gmail.com',
            "roles" => ["ROLE_USER"],
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
        // Création d'un utilisateur de type "contributeur" (= auteur)
        foreach (self::USERS as $userName) {
            $user = new User();
            $user->setEmail($userName['email']);
            $user->setRoles($userName['roles']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userName['password']
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
