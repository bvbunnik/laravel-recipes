<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Cuisine;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use App\Http\Requests;
use Carbon\CarbonInterval;
use App\Classes\ImportRecipe;

class RecipeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::orderBy('created_at', 'asc')->get();

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses_list = Course::lists('name')->toJson();
        $cuisines_list = Cuisine::lists('name')->toJson();
        $ingredients_list = Ingredient::lists('name')->toJson();
        $units_list = Unit::lists('name')->toJson();
        return view('recipes.create', compact('courses_list', 'cuisines_list', 'ingredients_list', 'units_list'));
    }

    public function import(Request $request)
    {
        $url = $request->url;
        $importRecipes = new ImportRecipe();
        $data = $importRecipes->scrape($url);
        $html = file_get_contents($url);
        $data1 = $importRecipes->parseIngredients($html, 'a');
        $recipe = new Recipe();
        $i = count($data->items) - 1;
        if (count($data1)==0) {
            $importRecipes->getIngredients($data, $recipe, $i);
        } else {
            $recipe->ingredients = $data1['descr'];
        }


        
        $instructions = mb_ereg_replace("\s{1,}", " ", $data->items[$i]->properties['recipeInstructions'][0]);

        $recipe->preparation = $instructions;
        //dd($recipe->preparation);
        $recipe->title = $data->items[$i]->properties['name'][0];

        if (array_key_exists('description', $data->items[$i]->properties)) {
            $recipe->description = trim(mb_ereg_replace("\s{1,}", " ", $data->items[$i]->properties['description'][0]));
        }
        
        //dd($data->items[1]->properties['totalTime'][0]);
        $di = new \DateInterval($data->items[$i]->properties['totalTime'][0]);
        $ci = CarbonInterval::instance($di);
        //dd($ci->minutes);
        $recipe->cooking_time = $ci->minutes;
        $recipe->servings = trim(substr($data->items[$i]->properties['recipeYield'][0],0,2));
        if (array_key_exists('recipeCategory', $data->items[$i]->properties)){
            $recipe->course_id = Course::firstorCreate(['name' => $data->items[$i]->properties['recipeCategory'][0]])->id;
        }
        if (array_key_exists('recipeCuisine', $data->items[$i]->properties)) {
            $recipe->cuisine_id = Cuisine::firstorCreate(['name' => $data->items[$i]->properties['recipeCuisine'][0]])->id;
        }
        if (substr($data->items[$i]->properties['image'][0],0,2)=="//"){
            $data->items[$i]->properties['image'][0] = "http:" . $data->items[$i]->properties['image'][0];
        }
        //n$img = Image::make($data->items[1]->properties['image'][0]);
        //$filename = 'files/photos/' . Carbon::now()->timestamp . '.pg';
        //$img->save($filename, 90);
        
        $recipe->photo = $data->items[$i]->properties['image'][0];
        //dd($recipe);
        return view('recipes.importform')->with('recipe', $recipe);
        //$recipe->save();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recipe = new Recipe;

        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->preparation = $request->preparation;
        $recipe->cooking_time = $request->cooking_time;
        $recipe->servings = $request->servings;
        $recipe->course_id = Course::firstorCreate(['name' => $request->course])->id;
        $recipe->cuisine_id = Cuisine::firstorCreate(['name' => $request->cuisine])->id;

        //Check if photo is added (either via file upload or URL)
        if ($request->hasFile('photo')){
            $filename = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move('public/files/photos/');
            $recipe->photo = 'public/files/photos/' . $filename;
        } elseif ($request->has('photo_url')){
            $img = Image::make($request->photo_url);
            $filename = 'files/photos/' . Carbon::now()->timestamp . '.png';
            $img->save($filename, 90);
            $recipe->photo = $filename;
        }

        $recipe->save();
        //$newrecipe = Recipe::find(['title' => $recipe->title]);
        for ($i=0; $i<count($request->ingredient); ++$i){
            $ingredient_id = Ingredient::firstorCreate(['name' => $request->ingredient[$i]])->id;

            $unit_id = Unit::firstorCreate(['name' => $request->unit[$i]])->id;

            $quantity = $request->quantity[$i];
            $recipe->ingredients()->attach($ingredient_id, ['quantity' => $quantity, 'unit_id' => $unit_id]);
        }
        return redirect()->action('RecipeController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::with('course', 'cuisine', 'ingredients')->findorFail($id);
        //$recipe = Recipe::findorFail($id);
        //$ingredients = $recipe->ingredients;
        //$course = $recipe->course->name;
        //dd($recipe);
        return view('recipes.recipe', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
