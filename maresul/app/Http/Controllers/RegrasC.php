<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regra;
use Illuminate\Support\Facades\DB;
class RegrasC extends Controller{

    public function index(){
        $regras = new Regra();
        $regras= DB::table('regras')->orderBy('created_at', 'desc')->paginate(2);         
        return view('adm.regras',compact('regras'))->with('msg', 'Nenhuma regra adicionada até o momento');

        
    }
    public function store(Request $request){
        $regra= new Regra();
        $regra->title= $request->input('tit');
        $regra->desc= $request->input('desc');
        $regra->reportdate= $request->input('dat');
        $regra->author= $request->input('aut');
        $regra->save();
        return redirect('/regras')->with('msg', 'Nova regra adicionada');
    }

    public function update(Request $request,$id){

        $regra = Regra::find($id);
        if(isset($regra)){
            try{
            $regra->title=$request->input('titEdit');
            $regra->desc=$request->input('descEdit');
            $regra->reportdate=$request->input('datEdit');
            $regra->author=$request->input('autEdit');
            $regra -> save(); 
            return  redirect('/regras')->with('msg', 'Regra Atualizada');
            }catch(\Exception $e){
                return  redirect('/regras');
            }  
        }
        return  redirect('/regras');
    }

    public function destroy($id){ //remover anuncio e redirecionar para pagina principal.
        $regra= Regra::find($id);
         if(isset($regra)){ 
             try{
             $regra->delete(); 
             return  redirect('/regras')->with('avs', 'Regra Removida');
            }catch(\Exception $e){
                return  redirect('/regras');
            }
        } 
        return  redirect('/regras');
    }
}
