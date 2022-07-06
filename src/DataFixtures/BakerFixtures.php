<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Baker;
use App\Entity\User;

class BakerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $baker = new Baker();
            $baker->setCreated($faker->dateTimeInInterval('-5 months', '+3 months'));
            $commercialName = $faker->optional()->randomElement(
                ['La fée des gâteaux', 'Super Cake', 'Maison Truffe', 'Cakery Lina', 'Chef Alex', 'Gâteau sur commande']
            );
            if (is_string($commercialName)) {
                $baker->setCommercialname($commercialName);
            }
            $baker->setFacebook("https://www.facebook.com/MyCakeEvent");
            $baker->setSiret(strval($faker->numberBetween(12345678901234, 98765432109876)));
            $baker->setProfilePicture('_fixtures_portrait-of-happy-male-chef-dressed-in-uniform.jpg');
            $baker->setDiploma('_fixtures_diploma.jpg');
            $baker->setLogo('_fixtures_logo_mycakeevent.png');
            $bakerType = $faker->randomElement(['professionnel', 'amateur']);
            if (is_string($bakerType)) {
                $baker->setBakerType($bakerType);
            }
            if ($this->getReference('user_' . $i) instanceof User) {
                $baker->setUser($this->getReference('user_' . $i));
            }
            if ($this->getReference('deliveryAddress_' . $i) instanceof Address) {
                $baker->setDeliveryAddress($this->getReference('deliveryAddress_' . $i));
            }
            $this->addReference('user_' . $i . '_baker_' . $i, $baker);

            $manager->persist($baker);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                UserFixtures::class, AddressFixtures::class,
            ];
    }
}
