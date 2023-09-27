<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $computer= Category::create([
            "name"=>'Bilgisayar',
            'image'=>'assets/images/children.jpg',
            "description"=>null,
            "cat_alt"=>null,
            "status"=>1,
        ]);
        Category::create([
            "name"=>'Apple',
            "description"=>null,
            "cat_alt"=>$computer->id,
            "status"=>1,
        ]);
       $phone= Category::create([
            "name"=>'Telefon',
           'image'=>'assets/images/men.jpg',
            "description"=>null,
            "cat_alt"=>null,
            "status"=>1,
        ]);
        Category::create([
            "name"=>'Kulaklık',
            "description"=>null,
            "cat_alt"=>$phone->id,
            "status"=>1,
        ]);
    }
}
