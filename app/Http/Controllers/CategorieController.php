<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /*public function index(){
        $categoriesParentes = Categorie::whereNull('id_categorie_parente')->get();
        return view('catalogue.index', compact('categoriesParentes'));
    }*/
}
