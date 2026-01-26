<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function index()
    {
        return view('grammar.placement');
    }
}
