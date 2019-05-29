<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriasC extends Controller
{
    

    public function store(Request $request){
        $cat= new Categoria();
        $cat->nome = $request->input('cat_nome');
        $cat->cat_desc= $request->input('cat_desc');
        $cat->save();
        return redirect('/forum')->with('msg','Categoria adicionada!');
    }
        
    public function destroy($id){

        $cat= Categoria::find($id);
        if(isset($cat)){ 
            $cat->delete(); 
            return redirect('/forum')->with('avs', 'Categoria removida!');
        } 
        return redirect('/forum')->with('avs', 'Não foi possível remover categoria!');
    }

    public function update(Request $request,$id){
                
        $cat = Categoria::find($id);

        $cat->nome = $request->input('edit_cat_nome');
        $cat->cat_desc = $request->input('edit_cat_desc');
        $cat->save();
        return  redirect('/forum')->with('msg', 'Categoria Atualizada');

    }
    
    
}
