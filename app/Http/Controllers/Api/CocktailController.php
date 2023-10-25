<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cocktail;
use Illuminate\Http\Request;

class CocktailController extends Controller {
    //
    public function index() {

        $queryString = request()->query();

        $cocktails = Cocktail::where("name", "LIKE", "%{$queryString["name"]}%")->get();

        return response()->json($cocktails);
    }

}
