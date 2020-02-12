<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Dits;

class CATController extends Controller
{
    public function index()
    {
        return Dits::sendResponse('Success Access API');
    }
}
