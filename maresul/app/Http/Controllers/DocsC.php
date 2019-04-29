<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocsC extends Controller{ //controller de documentos apenas inclui funções de listagem, criação e remoção.

    public function index(){

        $docs = DB::table('docs')->orderBy('created_at', 'desc')->paginate(10); //pega todos os documentos cadastrados e envia para a view
        return view('adm.documentos', ['docs' => $docs]);
  
    }

    public function store(Request $request){ //criar novo document
        try{
            $path = $request->file('file')->store('public'); //cria um novo arquivo na pasta storage e recupera o path
                if (empty($path)) {
                    return redirec('/documentos')->with('avs', 'Documento inválido.');
                }
            $doc = new Doc(); //instancia novo objeto de tipo Docs e armezena novos dados para ele.
            $doc->doc_title= $request->input('doc_title');
            $doc->doc_desc= $request->input('doc_desc');
            $doc->doc_path= $path;
            $doc->save();
            return  redirect('/documentos')->with('msg', 'Documento adicionado!');
        }catch(\Exception $e){
            return  redirect('/documentos')->with('avs','Documento inválido');
        }
        return redirect('/documentos'); 
        
    }

    public function destroy($id){ //remove o documento e seu path
        
        $doc= Doc::find($id);
        if(isset($doc)){ 
            Storage::delete($doc->doc_path);
            $doc->delete(); 
       } else{
           return "erro";
       }
       return  redirect('/documentos')->with('avs', 'Documento removido!');
    }
}
