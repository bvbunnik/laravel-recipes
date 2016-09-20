<?php

namespace App\Classes;

use linclark\MicrodataPHP\MicrodataPhp;
use DOMDocument;
use Illuminate\Support\Collection;

class ImportRecipe{
    public function scrape($html){
        $config = array('html' => $html);
        $md = new MicrodataPhp($config);
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

    public function curl_get_contents($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}