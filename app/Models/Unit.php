<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name'];

    public function ingredients()
    {
        return $this->hasMany('App\Models\Ingredient');
    }
}
