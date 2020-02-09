<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Dits;
use App\Models\Madrasah;

class PPDBController extends Controller
{
    public function listByID($id)
    {
        $jenjang = Dits::decodeDits($id);

        $result  = Madrasah::whereJenjang($jenjang)->get();
        return $result;
    }
}
