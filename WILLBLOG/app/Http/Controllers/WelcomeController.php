<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function fairposte()
    {
        return view('fairposte');
    }

    public function mespostes()
    {
        return view('mespostes');
    }
}

