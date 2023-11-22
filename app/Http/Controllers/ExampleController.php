<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function homepage()
    {
        return '<h1> Home Page!!</h1><a href="/about">go to about page</a>';

    }

    public function about()
    {
        return '<h1> About Page!!</h1><a href="/">Back Home</a>';

    }
}
