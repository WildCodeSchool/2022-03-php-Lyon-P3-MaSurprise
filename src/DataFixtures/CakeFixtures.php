<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Cake;
use App\Entity\Baker;
use App\DataFixtures\BakerFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CakeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i < 200; $i++) {
            $cake = new Cake();
            $cake->setCreated($faker->dateTimeInInterval('+1 months', '+1 months'));
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
                $cake->setName($name);
            }
            $picture1 = $faker->randomElement(
                [
                    '_fixtures_cake1.png',
                    '_fixtures_cake2.png,_fixtures_cake1.png',
                    '_fixtures_cupcake1.png,_fixtures_cake2.png,_fixtures_cake1.png',
                    '_fixtures_mount3.png,_fixtures_cupcake1.png,_fixtures_cake2.png,_fixtures_cake1.png',
                ]
            );
            if (is_string($picture1)) {
                $cake->setPicture1($picture1);
            }
            $category = $faker->randomElement([
                'Pièce montée',
                'Cupcake(s)',
                'Spécialité(s) étrangère(s)',
                'Mini gâteau',
                'Patisserie(s)',
                'Gâteau junior',
                'Gâteau sculpté',
                'Magnum cake(s)',
                'Pop cake(s)',
            ]);
            if (is_string($category)) {
                $cake->setCategory($category);
            }
            $cake->setAllergens($faker->optional(0.9)->randomElement([
                'cacahuète, noisette',
                'kiwi, fraise',
                'fruits à coque, lait, gluten',
                'lait, arachide'
            ]));
            $cake->setIngredients($faker->optional(0.9)->randomElement([
                'pâte à choux, caramel, crème pâtissière',
                'caramel au beurre salé, crème chantilly, noisettes',
                'génoise, crème pâtissière, fruit de la passion',
                'pâte feuilletée, crème pâtissière, chocolat au lait'
            ]));
            $cake->setDescription($faker->randomElement([
                "Le Saint-Pothin, lui, est un gâteau à base de crème pralinée et de couches de meringue. 
                On le trouve notamment dans les pâtisseries lyonnaises du 6e arrondissement 
                où est située l’église Saint-Pothin.",
                "Un mille-feuille, ou millefeuille, est une pièce de pâtisserie faite de trois 
                couches de pâte feuilletée et deux couches de crème pâtissière. Le dessus est glacé 
                avec du sucre glace ou du fondant. On peut y ajouter de la confiture ou des fruits.",
                "La forêt-noire, en allemand Schwarzwälder Kirschtorte, littéralement « gâteau 
                à la cerise de la Forêt-Noire », est une pâtisserie allemande constituée 
                de génoise au cacao imbibée de kirsch puis fourrée de crème chantilly et de cerises. 
                Elle est recouverte de crème chantilly et décorée de copeaux de chocolat.",
                "Le bavarois est un entremets pour lequel de la crème bavaroise (crème dérivée de 
                la crème anglaise à laquelle on a ajouté de la crème fouettée et de la gélatine) est 
                versée dans un moule et démoulée après prise.",
            ]));
            $cake->setPrice($faker->randomFloat(2, 12, 50));
            $size = $faker->randomElement(([
                '10/12 parts',
                '14/16 parts',
                '18/20 parts',
            ]));
            if (is_string($size)) {
                $cake->setSize($size);
            }
            $availability = $faker->randomElement([
                '3 jours',
                '7 jours',
                '10 jours',
                '1 jour',
                'NR',
            ]);
            if (is_string($availability)) {
                $cake->setAvailability($availability);
            }
            $reference = $faker->numberBetween(0, 19);
            $baker = $this->getReference('user_' . $reference . '_baker_' . $reference);
            if ($baker instanceof Baker) {
                $cake->setBaker($baker);
            }
            $manager->persist($cake);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                BakerFixtures::class,
            ];
    }
}
