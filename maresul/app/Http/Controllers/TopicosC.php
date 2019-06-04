<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Topico;
use App\User;
use App\Categoria;
use Auth;
use App\Admin;
use App\Voto;

class TopicosC extends Controller
{
    
    public function index(){
       
            $categorias= DB::table('Categorias')->get();  
            $votos = Voto::select('id_author','id_post')->distinct()->orderBy('id_author')->get();


        try{
            $auth= Auth::user()->isAdmin;

            if($auth==true){ //retornar view para admin     
                $topicos= DB::table('topicos')
                ->join('categorias', 'categorias.id', '=', 'topicos.id_cat')
                ->select('topicos.*','categorias.nome as cat')->Orderby('topicos.created_at','desc')->get();

                return view('adm.forum',compact('categorias','topicos','votos'));

            }else{ //retornar view para usuario
                $topicos= DB::table('topicos')
                ->join('categorias', 'categorias.id', '=', 'topicos.id_cat')
                ->select('topicos.*','categorias.nome as cat')->Orderby('topicos.created_at','desc')->paginate(10);
                return view('forum',compact('categorias','topicos','votos'));
            }
        }catch(\Exception $e){ //burlar acesso redireciona para página de login

            return redirect('/login');
        } 
    }

    public function topico($id){

        $top = Topico::find($id);
        $categorias= DB::table('Categorias')->get();
        $auth= Auth::user()->isAdmin;
        $topicos= DB::table('topicos')->get();
        $comentarios = DB::table('comentarios')->where('id_top','=',$id)->orderBy('created_at','desc')->get();

        try{
            if($top->admin_post==true){
                
                $top->top_views++;
                $top->save();
                $cat= Categoria::find($top->id_cat);
                $admin = Admin::where('name', 'like',$top->author)->first();
                if($auth==true){
                    return view('adm.topico',compact('top','admin','cat','categorias','topicos','comentarios'));
                }else{
                    return view('topico',compact('top','admin','cat','categorias','topicos','comentarios'));
                }
            }else{
                $top->top_views++;
                $top->save();
                $cat= Categoria::find($top->id_cat);
                $user = User::where('name', 'like',$top->author)->first();
                if($auth==true){
                    return view('adm.topico',compact('top','user','cat','categorias','topicos','comentarios'));
                }else{
                    return view('topico',compact('top','user','cat','categorias','topicos','comentarios'));
                }
            }
        }catch(\Exception $e){ 

            return redirect('\login');

        }
        
    }


    public function store(Request $request){

        $cat=Categoria::where('nome','like', $request->input('top_cat'))->first();
        
        try{
            $auth= Auth::user()->isAdmin;

            if($auth==true){  
                $top= new Topico();
                $top->top_titulo= $request->input('top_tit');
                $top->artigo= $request->input('artigo');
                $top->top_views= 0;
                $top->votos=0;
                $top->comentarios=0;
                $top->id_cat = $cat->id;
                $top->admin_post = true;
                $top->status_top = false;
                $top->author = Auth::user()->name;
                $top->save();
                return redirect()->route('topico', ['id' => $top->id])->with('msg','Tópico criado!');
            }else{ 
                $top= new Topico();
                $top->top_titulo= $request->input('top_tit');
                $top->artigo= $request->input('artigo');
                $top->top_views= 0;
                $top->votos = 0;
                $top->comentarios= 0;
                $top->id_cat = $cat->id;
                $top->admin_post = false;
                $top->status_top = false;
                $top->author = Auth::user()->name;
                $top->save();
                return redirect()->route('topico', ['id' => $top->id])->with('msg','Tópico criado!');
            }
            }catch(\Exception $e){ 

                return redirect('/login');
            } 
    }

    public function destroy($id){

        $top= Topico::find($id);

        try{
            $auth= Auth::user()->isAdmin; 
            if($auth==true){ 
                try{
                    $top= Topico::find($id);
                    if(isset($top)){ 
                        $top->delete(); 
                        return redirect('/forum')->with('msg', 'Tópico excluído!');
                        } 
                }catch(\Exception $e){ //caso remoção de erro no banco
                    return redirect('/forum')->with('avs', 'Não foi possível remover o tópico!');
                }
            }else{
                if(Auth::user()->name == $top->author){
                    try{
                        if(isset($top)){ 
                            $top->delete();
                            return redirect('/forum')->with('msg', 'Tópico excluido!'); 
                            }
                    }catch(\Exception $e){ 
                        return redirect('/forum')->with('avs', 'Não foi possível remover o tópico');
                    }
                }
                return redirect('/forum');
            }
            return redirect('/forum'); 
        }catch(\Exception $e){
            return redirect('/forum');
        }

    }

    public function close($id){
        $top = Topico::find($id);
        $top->status_top = true;
        $top->save();
        return redirect()->route('topico', ['id' => $top->id])->with('avs','Tópico marcado como encerrado');
    }

    public function categoria($id){
        $auth= Auth::user()->isAdmin;
        $ct = Categoria::find($id);
        $categorias= DB::table('Categorias')->get();  
        $votos = Voto::select('id_author','id_post')->distinct()->orderBy('id_author')->get();

        if($auth==true){
            $topicos= Topico::where('id_cat','=',$id)->get();
            return view('adm.categoria',compact('ct','categorias','topicos','votos'));
        }else{
            $topicos= Topico::where('id_cat','=',$id)->paginate(10);
            return view('categoria',compact('ct','categorias','topicos','votos'));
        }

    }

        public function update(Request $request,$id){
            
            $top = Topico::find($id);
            $cat=Categoria::where('nome','like', $request->input('editCat'))->first();

            try{
                if(isset($top)){
                    $auth= Auth::user()->isAdmin;
                    if($auth==true){ //retornar view para admin   
                        try{
                            $top->top_titulo= $request->input('editTit');
                            $top->artigo= $request->input('editDesc');
                            $top->id_cat = $cat->id;
                            $top->save();
                            return redirect()->route('topico', ['id' => $top->id])->with('msg','Tópico atualizado!');
                        }catch(\Exception $e){
                            return  redirect('/forum')->with('avs','Não foi atualizar');
                        }  
                    }else{
                            if(Auth::user()->name == $top->author){
                                try{
                                    $top->top_titulo= $request->input('editTit');
                                    $top->artigo= $request->input('editDesc');
                                    $top->id_cat = $cat->id;
                                    $top->save();
                                    return redirect()->route('topico', ['id' => $top->id])->with('msg','Tópico atualizado!');
                                }catch(\Exception $e){
                                    return redirect()->route('topico', ['id' => $top->id])->with('avs','Erro ao atualizar!');
                                }  
                            }
                    }
                }
            }catch(\Exception $e){
                return  redirect('/forum')->with('avs','Não foi atualizar o item desejado.');
            } 
        }

        public function search(Request $request){

            if($request->input('buscar') == null){
                return redirect('/forum');
            }
            $categorias = new Categoria();
            $categorias= DB::table('Categorias')->get(); 
            $votos = Voto::select('id_author','id_post')->distinct()->orderBy('id_author')->get();
            $word=$request->input('buscar');

            $topicos= DB::table('topicos')
            ->join('categorias', 'categorias.id', '=', 'topicos.id_cat',)
            ->select('topicos.*','categorias.nome as cat')->where('top_titulo','like','%'.$word.'%')->paginate(10);

            $pagination = $topicos->appends ( array (
                'buscar' => $request->input('buscar')
                ) );         
            
                return view('forum',compact('topicos','categorias','votos'))->with('src','busca');
        }
}



