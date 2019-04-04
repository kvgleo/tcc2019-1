<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminC extends Controller{
    
    public function __construct(){
        //$this->middleware('auth:admin');

    }

    public function index(){
        return view('adm.home_admin');
    }

    public function anuncios(){
        return view('adm.anuncios');
    }



}
