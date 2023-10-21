<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Cocktail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CocktailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    /*public function run(Faker $faker): void {
        $cocktails = ["Margarita", "Bloody Mary", "Tommy's Margarita", "Daiquiri", "Gin Fizz", "Paloma", "Ramos Fizz", "Negroni", "Americano", "Spritz", "Boulevardier", "Old Fashioned"];
        foreach ($cocktails as $cocktail) {
            $new_cocktail = new Cocktail();
            $new_cocktail->name = $cocktail;
            $new_cocktail->slug = Str::slug($new_cocktail->name);
            $new_cocktail->category = $faker->word();
            $new_cocktail->alcoholic = $faker->numberBetween(0,1);
            $new_cocktail->instructions = $faker->text(100);
            $new_cocktail->thumb = $faker->imageUrl(640, 480, 'animals', true);
            $new_cocktail->ingredients = json_encode($faker->paragraph());
            $new_cocktail->save();
        }
    }*/
    /* public function run(): void {
        $cocktails = Http::withOptions(['verify' => config('services.guzzle.verify')])->get('https://www.thecocktaildb.com/api/json/v1/1/random.php')->json('cocktails');
        dd($cocktails);

    }
} */

    public function run(Faker $faker): void
    {

        for ($i = 0; $i < 10; $i++) {
            $response = Http::withOptions(['verify' => config('services.guzzle.verify')])->get('https://www.thecocktaildb.com/api/json/v1/1/random.php');

            $cocktails = $response->json();

            foreach ($cocktails as $cocktail) {
                $drink = $cocktail[0];

                $new_cocktail = new Cocktail();

                $new_cocktail->name = $drink["strDrink"];
                $new_cocktail->slug = Str::slug($new_cocktail->name);
                $new_cocktail->category = $drink["strCategory"];
                $new_cocktail->alcoholic = $drink["strAlcoholic"];
                $new_cocktail->instructions = $drink["strInstructionsIT"];
                $new_cocktail->thumb = $drink["strDrinkThumb"];
                $new_cocktail->price = str_replace(".", ",", strval(number_format($faker->numberBetween(5,15), 2)));

                $ingredients = [];
                $counter = 1;

                do {
                    $key = "strIngredient" . $counter;
                    $ingredient = $drink[$key] ?? null;
                    if ($ingredient) {
                        $ingredients[] = $ingredient;
                    }
                    $counter++;
                } while ($ingredient != null);

                $new_cocktail->ingredients = json_encode($ingredients);

                $new_cocktail->save();
            };
        };
        /* dd($response->json()); */
    }
}
