<?php

namespace App\Http\Controllers;

class SectionController extends Controller
{
    public function show(string $name)
    {
        return view('section', ['name' => $name]);
    }
}
