<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Lembrete;
use Auth;

class LembretesC extends Controller{
    


    public function index(){
        
        $lembretes = DB::table('lembretes')->orderBy('created_at', 'desc')->paginate(2); //listar anuncios por ordem de criação e paginados
        return view('adm.lembretes', ['lembretes' => $lembretes]);
  
    }

    public function store(Request $request) //criar novo anuncio
    {
        $lembrete = new Lembrete();

        $lembrete->lemb_title= $request->input('lemb_tit');
        $lembrete->lemb_desc= $request->input('lemb_desc');
        $lembrete->reportdate= Carbon::now();
        $lembrete->save();
        return  redirect('a/le');
    }

    public function update(Request $request, $id)
    {
        $lembrete = Lembrete::find($id);

        if(isset($lembrete)){
            $lembrete->lemb_title=$request->input('titEdit');
            $lembrete->lemb_desc=$request->input('descEdit');
            $lembrete->reportdate= Carbon::now();
            $lembrete -> save(); 
            return  redirect('a/le');

            }else {

                return "erro";
            }
    }


    public function destroy($id){ //remover anuncio e redirecionar para pagina principal.
        $lembrete= Lembrete::find($id);
         if(isset($lembrete)){ 
             $lembrete->delete(); 
        } 
        return  redirect('a/le');
    }
}