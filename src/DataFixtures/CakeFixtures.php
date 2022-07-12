<?php

namespace App\DataFixtures;

use App\Entity\Baker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Cake;
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
                'Gâteau d\'anniversaire',
                'Forêt noire',
                'Pièce montée au caramel et fruits rouges',
                'Gâteau licorne',
                'Gâteau d\'anniversaire Peppa Pig',
                'Entremets aux fruits',
                'Saint-Pothin',
                'Tarte aux framboises',
                'Fraisier',
                'Gâteau à étages, crème au beurre',
                'Baba au rhum',
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
                'gluten',
                'kiwi, fraise',
                'lait',
                'noisette',
                'lait, gluten, noisette',
                'fruits à coque, lait, gluten',
                'gluten, kiwi',
                'lait, arachide'
            ]));
            $cake->setIngredients($faker->optional(0.9)->randomElement([
                'caramel, crème pâtissière',
                'chocolat au lait, crème anglaise',
                'poire, pomme, fraise',
                'pistache, chocolat, caramel',
                'caramel au beurre salé, crème chantilly, noisettes',
                'génoise, fraises, framboises',
                'génoise, crème pâtissière, fruit de la passion',
                'pâte feuilletée, crème pâtissière, chocolat au lait'
            ], 6, false));
            $cake->setDescription($faker->randomElement([
                "Le Saint-Pothin, lui, est un gâteau à base de crème pralinée et de couches de meringue. On le trouve notamment dans les pâtisseries lyonnaises du 6e arrondissement où est située l’église Saint-Pothin.",
                "Un mille-feuille, ou millefeuille, est une pièce de pâtisserie faite de trois couches de pâte feuilletée et deux couches de crème pâtissière. Le dessus est glacé avec du sucre glace ou du fondant. On peut y ajouter de la confiture ou des fruits.

                Il aurait été créé par François Pierre de La Varenne, qui le décrit dans son Cuisinier françois en 1651. Il aurait ensuite été perfectionné par Marie-Antoine Carême, cuisinier de Charles-Maurice de Talleyrand-Périgord.
                
                Cependant, beaucoup de pâtissiers professionnels ne le font remonter qu'à 1867, date à laquelle il fut proposé comme spécialité du célèbre pâtissier Adolphe Seugnot, alors installé 28 rue du Bac à Paris.",
                "La pièce montée est un dessert traditionnellement servi à la fin d'un mariage, d'une communion ou d'un repas de fête. Elle peut prendre différentes formes : pyramide de choux collés ensemble avec du caramel, superposition de gâteaux.

                Lors des mariages, une figurine représentant deux mariés est souvent placée au sommet de la pièce montée.",
                "La forêt-noire, en allemand Schwarzwälder Kirschtorte, littéralement « gâteau à la cerise de la Forêt-Noire », est une pâtisserie allemande constituée de génoise au cacao imbibée de kirsch puis fourrée de crème chantilly et de cerises. Elle est recouverte de crème chantilly et décorée de copeaux de chocolat.",
                "Le bavarois est un entremets pour lequel de la crème bavaroise (crème dérivée de la crème anglaise à laquelle on a ajouté de la crème fouettée et de la gélatine) est versée dans un moule et démoulée après prise. Il peut être aromatisé, en particulier avec une mousse de fruits. Il appartient à la famille des crèmes.",
                "La tarte peut être faite avec toutes sortes de variétés de pomme pourvu qu'elles soient acidulées. Éventuellement épluchées, elles sont coupées en morceaux ou préparées en compote. La tarte est garnie soit de pommes (parfois agrémentée d'une pointe de cannelle), soit de compote de pommes. Si elle est complétée par du flan et sans compote, elle sera dite « tarte à l'alsacienne ». Elle peut être parfumée à la noix de muscade ou à la cannelle et servie avec une boule de glace à la vanille, de la crème fraîche, voire accompagnée d'une tranche de cheddar aux États-Unis. Les ingrédients principaux sont : La pâte (farine de blé, sucre, beurre) et, surtout, les pommes." 
            ]));
            $cake->setPrice($faker->randomFloat(2, 12, 50));
            $size = $faker->randomElement(([
                '6/8 parts',
                '10/12 parts',
                '14/16 parts',
                '18/20 parts',
            ]));
            if (is_string($size)) {
                $cake->setSize($size);
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
