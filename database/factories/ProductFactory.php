<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryId=[1,2,3,4];
        $color=['Siyah','Beyaz','Silver','Gold','Mavi','Gri'];
        $colortext = $color[random_int(0,5)];
        return [
            'name'=> $colortext.' '. ' Son teknoloji ürünü',
            'category_id'=>$categoryId[random_int(0,3)],
            'short_text'=>$categoryId[random_int(0,3)]. 'idli ürün',
            'price'=>random_int(100,500),
            'color'=>$colortext,
            'quantity'=>14,
            'description'=>'Açıklama',
            'status'=>'1',
        ];
    }
}
