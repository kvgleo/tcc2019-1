<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncio;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;

class AnunciosC extends Controller
{
  

    public function index(){
        $anuncios = DB::table('anuncios')->orderBy('created_at', 'desc')->paginate(5); //listar anuncios por ordem de criação e paginados
        return view('adm.anuncios', ['anuncios' => $anuncios]);
  
    }

    public function store(Request $request) //criar novo anuncio
    {
        $anuncio = new Anuncio();

        $anuncio->title= $request->input('tit');
        $anuncio->description= $request->input('desc');
        $anuncio->reportdate= Carbon::now();
        $anuncio->ps= $request->input('obs');
        $anuncio->email= false;
        $anuncio->save();
        return  redirect('/anuncios')->with('msg', 'Novo anuncio adicionado!');
    }

    public function email($id){

        $anuncio= Anuncio::find($id);
        $user1 = DB::table('users')->orderBy('created_at', 'desc')->get()->toArray();

        foreach($user1 as $u){

            $data = array(
                'email'=> $u->email,
                'title'=>$anuncio->title
                );

        Mail::send('adm.anunciosEmail', ['desc' => $anuncio->description, 'obs'=> $anuncio->ps ],  function($m) use ($data){
        $m->from('leonardo.silveira@ulbra.inf.br');
        $m->subject( "Novo Comunicado! - ". $data['title']);
        $m->to($data['email']);
        });
        }

        $anuncio->email = true;
        $anuncio->save();

        return redirect('/anuncios')->with('msg', 'Email Enviado!');
        
    }
    public function search(Request $request){
        
        if($request->input('buscar') == null){
            return redirect('/anuncios');
        }
        $word=$request->input('buscar');
        $anuncios = new Anuncio();
        $anuncios= DB::table('anuncios')->where('title','like','%'.$word.'%')->orderBy('created_at', 'desc')->paginate(4);
        $pagination = $anuncios->appends ( array (
            'buscar' => $request->input('buscar')
          ) );      

        try{
            $auth= Auth::user()->isAdmin;
            if($auth==true){ //retornar view para admin
                return view('adm.anuncios',compact('anuncios'))->with('src','busca');
                 
            }else{ //retornar view para usuario

                return view('anuncios',compact('anuncios'))->with('src','busca');

            }
        }catch(\Exception $e){ //burlar acesso redireciona para página de login

            return redirect('/login');
        }
    }

    public function update(Request $request, $id)
    {
        $anuncio = Anuncio::find($id);
        if(isset($anuncio)){
            $anuncio->title=$request->input('titEdit');
            $anuncio->description=$request->input('descEdit');
            $anuncio->ps=$request->input('obsEdit');
            $anuncio -> save(); 
            return  redirect('/anuncios')->with('msg', 'o anuncio foi atualizado!');
            }else {
                return "erro";
            }
    }


    public function destroy($id){ //remover anuncio e redirecionar para pagina principal.
        $anuncio= Anuncio::find($id);
         if(isset($anuncio)){ 
             $anuncio->delete(); 
        } 
        return  redirect('/anuncios')->with('avs','O anuncio foi removido!');
    }
}
