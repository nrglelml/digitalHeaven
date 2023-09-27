<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slider::create([
            'image' => '/assets/images/cmptr2.jpg',
            'name' => 'Slider1',
            'description' => 'E-ticaret sitemize hoşgeldiniz',
            'link'=> 'urunler',
            'status'=>'1'
        ]);
    }
}
