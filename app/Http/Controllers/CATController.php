<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CATController extends Controller
{
    public function index()
    {
        return view('pages.CAT.index');
    }
}
