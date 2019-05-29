<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recado;
use Illuminate\Support\Facades\DB;
use Auth;

class RecadosC extends Controller
{

    public function index(){

        $recados = new Recado();
        $recados= DB::table('recados')
                ->join('users', 'users.id', '=', 'recados.id_user',)
                ->select('recados.*', 'users.*','recados.id','recados.created_at')->where('deleted_at','=', null)->orderBy('recados.created_at', 'desc')->get();
            
        $recados2= Recado::onlyTrashed()->join('users', 'users.id', '=', 'recados.id_user',)
                ->select('recados.*', 'users.*','recados.id','recados.created_at')->orderBy('recados.deleted_at', 'desc')->get();
                
            return view('adm.recados',compact('recados','recados2'));
    }


    public function store(Request $request){

        $recado = new Recado();
        $recado->assunto= $request->input('assunto');
        $recado->rec_desc= $request->input('desc');
        $recado->id_user= Auth::user()->id;
        $recado->save();
        return back()->with('msg','Sucesso! Recado enviado!');
    }

    public function destroy($id){ //remover regra e redirecionar para pagina principal.
        $recado = Recado::find($id);
        $recado->delete(); 
        return  redirect('/recados')->with('avs', 'Recado arquivado!');
    }


}
