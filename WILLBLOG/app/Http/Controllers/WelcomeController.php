<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //pour vue racine
    public function index()
    {
        return view('welcome');
    }

    //pour vue page faire un poste
    public function fairposte()
    {
        return view('fairposte');
    }

    //pour vue page mes postes
    public function mespostes()
    {
        return view('mespostes');
    }
}

