<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AboutUs::create([
            'name'=>'Digital Heaven E-ticaret',
            'description'=>'Hakkımızda yazımız burada',

            'text_1_icon'=>'icon-truck',
            'text_1_title'=>'ÜCRETSIZ KARGO!',
            'text_1_content'=>'Digital Heaven ile kargolar bedava',

            'text_2_icon'=>'icon-refresh2',
            'text_2_title'=>'ÜCRETSİZ İADE SEÇENEĞİ',
            'text_2_content'=>'Ürünlerinizi hiçbir karşılık olmadan kolaylıkla iade edebilirsiniz',

            'text_3_icon'=>'icon-help',
            'text_3_title'=>'MÜŞTERİ HIZMETLERİ',
            'text_3_content'=>'Digital Heaven da 7/24 müşterilerimizle ilgileniriz',

        ]);
    }
}
