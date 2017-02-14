<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use Searchable;

    protected $fillable=['title', 'preparation', 'notes', 'cooking_time', 'servings', 'cuisine_id', 'course_id'];

    public function cuisine()
    {
        return $this->belongsTo('App\Models\Cuisine');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient')->withPivot('quantity', 'unit_id')
            ->join('units', 'ingredient_recipe.unit_id', '=', 'units.id')
            ->select('ingredients.*', 'units.name AS units_title');
    }

    public function searchableAs()
    {
        return 'recipes_index';
    }
}
