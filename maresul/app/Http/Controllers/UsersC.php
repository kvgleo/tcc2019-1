<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersC extends Controller
{
    
    public function index(){

        $users = new User();
        $users= DB::table('users')->orderBy('created_at', 'desc')->get();  

        $admins = new Admin();
        $admins= DB::table('admins')->orderBy('created_at', 'desc')->get();   

        try{
            $auth= Auth::user()->isAdmin;

            if($auth==true){ //retornar view para admin       
                return view('adm.comunidade',compact('users','admins'));
            }else{ //retornar view para usuario
                return view('comunidade',compact('users','admins'));
            }
            }catch(\Exception $e){ //burlar acesso redireciona para página de login

                return redirect('/login');
            } 
    }

    public function destroy($id){ //remover regra e redirecionar para pagina principal.
        $user= User::find($id);
        $user->delete(); 
        return  redirect('/comunidade')->with('avs', 'O usuário foi removido!');
    }

    

    public function update(Request $request,$id){

        $user = User::find($id);
        try{
            if(isset($user)){
                $auth= Auth::user()->isAdmin;
                if($auth==true){ //retornar view para admin   
                    try{
                        $user->name=$request->input('editName');
                        $user->email=$request->input('editEmail');
                        $user->apto=$request->input('editApto');

                        if($request->input('editPassword')==null){
                            $user->save();
                            return  redirect('/comunidade')->with('msg', 'Dados de usuário atualizados');
                        }else{
                            $user->password= Hash::make($request->input('EditPassword'));
                            $user -> save(); 
                            return  redirect('/comunidade')->with('msg', 'Dados de usuário atualizados');
                        }
                    }catch(\Exception $e){
                        return  redirect('/comunidade')->with('avs','Não foi atualizar o item desejado.');
                    }  
                }else{
                    try{
                        if($user->id == Auth::user()->id){
                            $user->name=$request->input('editName');
                            $user->email=$request->input('editEmail');
                            $user->bio=$request->input('editBio');
                            $user->save();
                            return  redirect('/comunidade')->with('msg', 'Seus dados foram atualizados!');
                        }else{
                            return  redirect('/comunidade')->with('avs','Erro ao atualizar');
                        }
                    }catch(\Exception $e){
                        return  redirect('/comunidade')->with('avs','Erro ao atualizar');
                    }  

                }
            }

        }catch(\Exception $e){
            return  redirect('/comunidade')->with('avs','Não foi atualizar o item desejado.');
        }  
        return  redirect('/comunidade');
    }

    public function inp($tipo, $id){

        $user= User::find($id);
        
        if($tipo == 'i'){
            $user->inp = true;
            $user->save();
            return redirect('/comunidade')->with('avs', 'Usuário inadimplente atualizado!');
        }elseif($tipo== 'a'){
            $user->inp = false;
            $user->save();
            return redirect('/comunidade')->with('msg', 'Usuário adimplente atualizado!');

        }elseif($tipo == 'all'){
            User::query()->update(['inp' => true]);
            return redirect('/comunidade')->with('avs', 'todos usuários atualizados inadimplentes!');
            
           
        }
    }


    public function store(Request $request, $id){

        if($id == 0){
            try{
                if($request->input('password')== null){

                    return redirect('/comunidade')->with('avs','Senha não cadastrada');
                }
                $user= new User();
                $user->name= $request->input('name');
                $user->email= $request->input('email');
                $user->apto= $request->input('apto');
                $user->inp= false;
                $user->password= Hash::make($request->input('password'));
                $user->save();
                return redirect('/comunidade')->with('msg', 'Novo usuário cadastrado!');
            }catch(\Exception $e){
                return  redirect('/comunidade')->with('avs','Não foi possível cadastrar! (tente novamente)');
            }
        }  

        if($id == 1){
            try{
                if($request->input('password')== null){

                    return redirect('/comunidade')->with('avs','Senha não cadastrada');
                }
                $admin= new Admin();
                $admin->name= $request->input('name');
                $admin->email= $request->input('email');
                $admin->isAdmin = true;
                $admin->password= Hash::make($request->input('password'));
                $admin->save();
                return redirect('/comunidade')->with('msg', 'Novo administrador cadastrado!');
            }catch(\Exception $e){
                return  redirect('/comunidade')->with('avs','Não foi possível cadastrar! (tente novamente)');
            }
        }  
    }










}

