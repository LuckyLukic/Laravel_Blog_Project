<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function homepage()
    {

        $myName = "Luca";
        $animals = ["tiger", "leon", "elephant"];

        return view('homepage', ["allAnimals" => $animals, "name" => $myName, "catName" => "Sissa"]);

    }

    public function about()
    {
        return view('single-post');

    }
}
