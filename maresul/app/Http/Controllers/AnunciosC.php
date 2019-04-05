<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AnunciosC extends Controller
{
  

    public function index(){
        $anuncios = DB::table('anuncios')->orderBy('created_at', 'desc')->paginate(2); //listar anuncios por ordem de criação e paginados
        return view('adm.anuncios', ['anuncios' => $anuncios]);
  
    }

    public function store(Request $request) //criar novo anuncio
    {
        $anuncio = new Anuncio();

        $anuncio->title= $request->input('tit');
        $anuncio->description= $request->input('desc');
        $anuncio->reportdate= Carbon::now();
        $anuncio->ps= $request->input('obs');
        $anuncio->save();
        return  redirect('a/a');
    }

    public function update(Request $request, $id)
    {
        $anuncio = Anuncio::find($id);
        if(isset($anuncio)){
            $anuncio->title=$request->input('titEdit');
            $anuncio->description=$request->input('descEdit');
            $anuncio->ps=$request->input('obsEdit');
            $anuncio -> save(); 
            return  redirect('a/a');
            }else {
                return "erro";
            }
    }


    public function destroy($id){ //remover anuncio e redirecionar para pagina principal.
        $anuncio= Anuncio::find($id);
         if(isset($anuncio)){ 
             $anuncio->delete(); 
        } 
        return  redirect('a/a');
    }
}
