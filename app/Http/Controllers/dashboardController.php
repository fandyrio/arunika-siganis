<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index(){
    return view('arunika/index_arunika');
    }
}
