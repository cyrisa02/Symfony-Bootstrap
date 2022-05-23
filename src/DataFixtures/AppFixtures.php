<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{

    /**
     * Faker
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        // Ingredients il faut les mettre dans un array pour les recettes
        $ingredients = [];
        for ($i = 0; $i < 50; ++$i) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
            ->setPrice(mt_rand(0, 100));

            $ingredients[]= $ingredient;
            
            $manager->persist($ingredient);
        }

        // Recipes
        for ($j = 0; $j < 25 ; $j++) {
            $recipe = new Recipe();
            $recipe->setName($this->faker->word())
            ->setTime(mt_rand(0,1440))
            ->setNbPeople(mt_rand(0,50))
            ->setDifficulty(mt_rand(0,6))
            ->setDescription($this->faker->text(350))
            ->setPrice(mt_rand(0,1000))
            ->setIsFavorite(mt_rand(0,1) == 1 ? true :false)
            ->setIsPublic(mt_rand(0,1) == 1 ? true :false);
            
            for ($k = 0; $k < mt_rand(5, 15); $k++) {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }
            $manager->persist($recipe);

        }

        $manager->flush();
    }
}
