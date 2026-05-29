<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    public function index(){
        $pays = Pays::allDistinct();
        return view('components.header-sticky', compact('pays'));
    }
}
