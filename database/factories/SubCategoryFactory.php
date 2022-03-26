<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subcategory;

class SubCategoryFactory extends Factory
{
    protected $model = Subcategory::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => 'subcategories/' . $this->faker->image('public/storage/subcategories', 640, 480, null, false)
        ];
    }
}
