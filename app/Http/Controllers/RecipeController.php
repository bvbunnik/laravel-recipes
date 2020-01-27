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
        $recipes = Recipe::orderBy('rating', 'desc')->get();

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses_list = Course::pluck('name')->toJson();
        $cuisines_list = Cuisine::pluck('name')->toJson();
        $ingredients_list = Ingredient::pluck('name')->toJson();
        $units_list = Unit::pluck('name')->toJson();
        return view('recipes.create', compact('courses_list', 'cuisines_list', 'ingredients_list', 'units_list'));
    }

    public function import_recipe()
    {
    	return view('recipes.import');
    }


    public function import(Request $request)
    {
        $url = $request->url;
        $importRecipes = new ImportRecipe();
        $html = $importRecipes->curl_get_contents($url);
        $data = $importRecipes->scrape($html);
        $data1 = $importRecipes->parseIngredients($html, 'a');
        //dd($data, $data1);
        $recipe = new Recipe();
        if (count($data->items)>2){
            $i=0;
        } else {
            $i = count($data->items) - 1;
        }

        if (count($data1)==0) {
            $importRecipes->getIngredients($data, $recipe, $i);
        } else {
            $recipe->ingredients['descr'] = $data1['descr'];
            $recipe->ingredients['unit'] = $data1['unit'];
            $recipe->ingredients['quantity'] = $data1['quantity'];
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
        //$img = Image::make($data->items[1]->properties['image'][0]);
        //$filename = 'files/photos/' . Carbon::now()->timestamp . '.pg';
        //$img->save($filename, 90);
        
        $recipe->photo_url = $data->items[$i]->properties['image'][0];

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
            $request->file('photo')->move('files/photos/');
            $recipe->photo = 'files/photos/' . $filename;
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

    public function rate(Request $request, $id)
    {
        $recipe = Recipe::findorFail($id);
        $recipe->rating = $request->rating;
        $recipe->save();
        return response()->json([
            "rating" => $recipe->rating
        ]);
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

    public function showFavourites()
    {
        $recipes = Recipe::where('favourite',1)->orderBy('rating', 'desc')->get();

        return view('recipes.index', compact('recipes'));
    }

    public function toggleFavourite($id)
    {
        $recipe = Recipe::findorFail($id);

        $recipe->favourite = !$recipe->favourite;
        $recipe->save();
        return redirect()->action('RecipeController@index');
    }

    public function search(Request $request)
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No results found, please try with different keywords.'];

        // Making sure the user entered a keyword.
        if($request->has('q')) {

            // Using the Laravel Scout syntax to search the products table.
            $recipes = Recipe::search($request->get('q'))->get();

            // If there are results return them, if none, return the error message.
            if ($recipes->count()) {
                return view('recipes.index', compact('recipes'));
            } else {
                return view('recipes.index', compact('error'));
        }
        return view('recipes.index', compact('error'));
    }
    }
}
