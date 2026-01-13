<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstantTutoringController extends Controller
{
    public function index(){
        return view('vistas.view.pages.tutorias-instantaneas');
    }
}
