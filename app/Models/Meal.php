<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Meal extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = ['status', 'category_id', 'ingredient_id', 'tag_id'];

    public $translatedAttributes = ['title', 'description', 'ingredients'];

    // Define the relationship with the 'category' table
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Define the relationship with the 'ingredient' table
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    // Define the relationship with the 'tags' table
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}

