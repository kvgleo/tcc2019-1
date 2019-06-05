<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recado;
use Illuminate\Support\Facades\DB;

class AdminC extends Controller{
    
    public function index(){
        $lancamentos = DB::table('lancamentos')->orderBy('created_at','desc')->limit(5)->get();

        $topicos= DB::table('topicos')
                ->join('categorias', 'categorias.id', '=', 'topicos.id_cat')
                ->select('topicos.*','categorias.nome as cat')->Orderby('topicos.created_at','desc')->limit(3)->get();

        $recados = new Recado();
        $recados= DB::table('recados')
                ->join('users', 'users.id', '=', 'recados.id_user',)
                ->select('recados.*', 'users.*','recados.id','recados.created_at')->where('deleted_at','=', null)->orderBy('recados.created_at', 'desc')->limit(3)->get();


        return view('adm.home_admin',compact('recados','topicos','lancamentos'));
    }




}
