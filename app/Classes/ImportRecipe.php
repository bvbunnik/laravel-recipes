<?php

namespace App\Classes;

use linclark\MicrodataPHP\MicrodataPhp;
use DOMDocument;
use Illuminate\Support\Collection;

class ImportRecipe{
    public function scrape($url){
        $md = new MicrodataPhp($url);
        $data = $md->obj();
        return $data;
    }

    public function parseIngredients($content,$tg)
    {
        $dom = new DOMDocument;
        @$dom->loadHTML($content);

        $ingr = array();
        foreach ($dom->getElementsByTagName($tg) as $tag) {
            foreach ($tag->attributes as $attribName => $attribNodeVal)
            {
                if ($attribName=='data-quantity'){
                    $ingr['quantity'][] = $tag->getAttribute($attribName);
                }
                if ($attribName=='data-description-singular'){
                    $ingr['descr'][] = $tag->getAttribute($attribName);
                }
                if ($attribName=='data-quantity-unit-singular'){
                    $ingr['unit'][] = $tag->getAttribute($attribName);
                }
                if ($attribName=='data-additional-info'){
                    $ingr['info'][] = $tag->getAttribute($attribName);
                }
            }
        }
        return $ingr;
    }

    /**
     * @param $data
     * @param $recipe
     */
    public function getIngredients(&$data, &$recipe, $i)
    {
        $itemname = '';

        if (array_key_exists('ingredients', $data->items[$i]->properties)) {
            $itemname = 'ingredients';
        }
        if (array_key_exists('recipeIngredient', $data->items[$i]->properties)) {
            $itemname = 'recipeIngredient';
        }
        if (count($data->items[$i]->properties[$itemname]) > 1) {
            foreach ($data->items[$i]->properties[$itemname] as $ingredient) {
                $recipe->ingredients[] = trim(preg_replace("/\s{1,}/", " ", $ingredient));
            }
        } else {
            $temp_data = explode("\n", $data->items[$i]->properties[$itemname][0]);
            foreach ($temp_data as $ingredient) {
                $recipe->ingredients[] = trim(preg_replace("/\s{1,}/", " ", $ingredient));
            }
        }

    }
}