<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pergunta;
use Illuminate\Support\Facades\DB;
use Auth;

class PerguntasC extends Controller
{
    public function index(){

        $perguntas = new Pergunta();
        $perguntas= DB::table('perguntas')->orderBy('created_at', 'desc')->paginate(2);  

        try{
            $auth= Auth::user()->isAdmin;
            if($auth==true){ //retornar view para admin
                    return view('adm.ajuda',compact('perguntas'));
                 
            }else{ //retornar view para usuario

                return view('ajuda',compact('perguntas'));

            }
        }catch(\Exception $e){ //burlar acesso redireciona para página de login

            return redirect('/login');
        }
       
    }
    public function store(Request $request){
        $perg= new Pergunta();
        $perg->question= $request->input('perg');
        $perg->answer= $request->input('resp');
        $perg->save();
        return redirect('/ajuda')->with('msg', 'Nova pergunta adicionada');
    }

    public function update(Request $request,$id){

        $perg = Pergunta::find($id);
        if(isset($perg)){
            try{
            $perg->question=$request->input('pergEdit');
            $perg->answer=$request->input('respEdit');
            $perg -> save(); 
            return  redirect('/ajuda')->with('msg', 'Pergunta Atualizada');
            }catch(\Exception $e){
                return  redirect('/ajuda')->with('avs','não foi atualizar remover o item desejado.');;
            }  
        }
        return  redirect('/ajuda');
    }

    public function destroy($id){ //remover anuncio e redirecionar para pagina principal.
        $perg= Pergunta::find($id);
         if(isset($perg)){ 
             try{
             $perg->delete(); 
             return  redirect('/ajuda')->with('avs', 'Pergunta Removida');
            }catch(\Exception $e){
                return  redirect('/ajuda')->with('avs','não foi possível remover o item desejado.');
            }
        } 
        return  redirect('/ajuda');
    }
}
