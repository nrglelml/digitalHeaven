<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;
    use HasFactory;
    protected $guarded=[];


    public function items() {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function subcategory() {
        return $this->hasMany(Category::class,'cat_alt','id');
    }


    public function category() {
        return $this->hasOne(Category::class,'id','cat_alt');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
