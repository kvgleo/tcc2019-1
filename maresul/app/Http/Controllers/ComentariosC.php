<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topico;
use Auth;
use App\Comentario;
class ComentariosC extends Controller
{
    //
    public function store(Request $request, $id){

        $top = Topico::find($id);
        $top->comentarios++;
        $top->save();

        try{
            $auth= Auth::user()->isAdmin;

            if($auth==true){  
                $comment = new Comentario();
                $comment->id_top = $id;
                $comment->author = Auth::user()->name;
                $comment->admin_c = true;
                $comment->mensagem = $request->input('msg');
                $comment->save();
                return redirect()->route('topico', ['id' => $top->id])->with('msg','Comentário Adicionado!');

            }else{
                $comment = new Comentario();
                $comment->id_top = $id;
                $comment->author = Auth::user()->name;
                $comment->admin_c = false;
                $comment->mensagem = $request->input('msg');
                $comment->save();
                return redirect()->route('topico', ['id' => $top->id])->with('msg','Comentário Adicionado!');
            }
        }catch(\Exception $e){ 
            return redirect('/login');
        } 


    }

    public function update(Request $request,$id,$id_top){
            
        $top = Topico::find($id_top);
        $comment = Comentario::find($id);

        try{
            if(isset($top)){
                $auth= Auth::user()->isAdmin;
                if($auth==true){ 
                    try{
                        $comment->mensagem = $request->input('msg');
                        $comment->save();
                        return redirect()->route('topico', ['id' => $top->id])->with('msg','Comentário Atualizado!');

                    }catch(\Exception $e){
                         return redirect()->route('topico', ['id' => $top->id])->with('avs','Não foi possível remover comentário');
                    }  
                }else{
                    if(Auth::user()->name == $top->author){
                        try{
                        $comment->mensagem = $request->input('msg');
                        $comment->save();
                        return redirect()->route('topico', ['id' => $top->id])->with('msg','Comentário Atualizado!');

                        }catch(\Exception $e){
                            return redirect()->route('topico', ['id' => $top->id])->with('avs','Não foi possível remover comentário');
                        }  
                    }
                }
            }
        }catch(\Exception $e){
            return redirect()->route('topico', ['id' => $top->id])->with('avs','Não foi possível remover comentário');
        } 
    }


    public function destroy($id, $top_id){
        $top= Topico::find($top_id);
        $c = Comentario::find($id);
        try{
            $auth= Auth::user()->isAdmin; 
            if($auth==true){ 
                try{
                    if(isset($c)){ 
                        $c->delete();
                        $top->comentarios--;
                        $top->save();
                        return redirect()->route('topico', ['id' => $top->id])->with('avs','Comentário removido!');
                    }
                }catch(\Exception $e){ //caso remoção de erro no banco
                    return redirect('/forum')->with('avs', 'Não foi possível remover o tópico!');
                }
            }else{
                if(Auth::user()->name == $c->author){
                    try{
                        if(isset($c)){ 
                            $c->delete();
                            $top->comentarios--;
                            $top->save();
                            return redirect()->route('topico', ['id' => $top_id])->with('avs','Comentário removido!');
                        }
                    }catch(\Exception $e){ 
                        return redirect()->route('topico', ['id' => $top_id])->with('avs','Não foi possível remover o comentário');
                    }
                }
                return redirect()->route('topico', ['id' => $top_id])->with('avs','Não foi possível remover o comentário');
            }
            return redirect()->route('topico', ['id' => $top_id])->with('avs','Não foi possível remover o comentário');
        }catch(\Exception $e){
            return redirect('/login');
        
        }
    }
    
}
