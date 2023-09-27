<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Urun 1',
            'image'=> 'assets/images/shoe_1.jpg',
            'category_id' => 1,
            'short_text'  => 'Kısabilgi',
            'price'=> 100,
            'color'=> 'Beyaz',
            'quantity'=> 10,
            'status'=> '1',
            'description'=> '<p>Ürün baya iyi</p>'
        ]);


        Product::create([
            'name' => 'Urun 2',
            'image'=> 'assets/images/cloth_2.jpg',
            'category_id' => 3,
            'short_text'  => 'Kısabilgi 2',
            'price'=> 150,
            'color'=> 'Siyah',
            'quantity'=> 5,
            'status'=> '1',
            'description'=> '<p>Ürün Açıklama</p>'
        ]);
    }

}
