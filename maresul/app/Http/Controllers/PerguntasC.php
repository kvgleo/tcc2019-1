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
        $perguntas= DB::table('perguntas')->orderBy('created_at', 'desc')->paginate(4);  

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
        return redirect('/ajuda')->with('msg', 'Uma nova informação foi adicionada!');
    }

    public function update(Request $request,$id){

        $perg = Pergunta::find($id);
        if(isset($perg)){
            try{
            $perg->question=$request->input('pergEdit');
            $perg->answer=$request->input('respEdit');
            $perg -> save(); 
            return  redirect('/ajuda')->with('msg', 'Informação atualizada!');
            }catch(\Exception $e){
                return  redirect('/ajuda')->with('avs','Não foi atualizar o item desejado.');
            }  
        }
        return  redirect('/ajuda');
    }

    public function destroy($id){ //remover anuncio e redirecionar para pagina principal.
        $perg= Pergunta::find($id);
        if(isset($perg)){ 
             try{
             $perg->delete(); 
             return  redirect('/ajuda')->with('avs', 'A informação foi excluida!');

            }catch(\Exception $e){
                return  redirect('/ajuda')->with('avs','Não foi possível remover o item desejado.');
            }
        } 
        return  redirect('/ajuda');
    }
}
