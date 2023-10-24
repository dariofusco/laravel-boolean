<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cocktail;
use Illuminate\Http\Request;

class CocktailController extends Controller {
    //
    public function index() {
      
        $queryString = request()->query();
      

        $cocktails = Cocktail::all()->where("name",   $queryString["name"]);
        $query = $cocktails;
        if(array_key_exists("name", $queryString) && $queryString["name"]){
            $query->where("name", "LIKE", "%{$queryString["name"]}%");
        }

        
        return response()->json($cocktails);
    }

}
