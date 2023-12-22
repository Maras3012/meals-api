<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Tag extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = [
        'slug',
    ];

    public $translatedAttributes = ['title'];

    /**
     * Get the meals for the tag.
     */
    public function meals()
    {
        return $this->hasMany(Meal::class, 'tag_id');
    }
}

