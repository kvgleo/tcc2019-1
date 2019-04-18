<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Reserva;

class ReservasC extends Controller{


    public function index(){
        
        $reservas = DB::table('reservas')
                    ->join('users', 'users.id', '=', 'reservas.id_user',)
                    ->select('reservas.*', 'users.*','reservas.id','reservas.created_at')->orderBy('reservas.created_at', 'desc')->paginate(5);
        try{
            $auth= Auth::user()->isAdmin;
            if($auth==true){ //retornar view para admin
                return view('adm.reservas',compact('reservas'));
                 
            }else{ //retornar view para usuario
        
                return view('reservas',compact('reservas'));

            }
        }catch(\Exception $e){ //burlar acesso redireciona para página de login

            return redirect('/login');
        }
    }

    public function store(Request $request){
        
        if($request->input('dia')==null){
            return redirect('/reservas')->withErrors('Data Inválida');
        }
        try{
        $reserva = new Reserva();
        $reserva->reportdate= $request->input('dia');
        $reserva->id_user=  Auth::user()->id;
        $reserva->local_targ= $request->input('local');
        $reserva->save();
        return  redirect('/reservas')->with('msg', 'Sua reserva foi adicionada!');

        }catch(\Exception $e){ //burlar acesso redireciona para página de login

        return redirect('/reservas')->withErrors('Não foi possível registrar a reserva do local pois já existe um registro no mesmo dia.');
    }

    }

    public function destroy($id,$id_user){

        try{
            $auth= Auth::user()->isAdmin; //se for admin, tentar deletar reserva no banco
            if($auth==true){ 
                try{
                    $reserva= Reserva::find($id);
                    if(isset($reserva)){ 
                        $reserva->delete(); 
                        return redirect('/reservas')->with('msg', 'Reserva cancelada!');
                        } 
                    return redirect('/reservas')->withErrors('Erro: Não foi possível cancelar a reserva');
                }catch(\Exception $e){ //caso remoção de erro no banco
                    return redirect('/reservas')->withErrors('Erro: Não foi possível cancelar a reserva');
                }
            }else{
                if(Auth::user()->id==$id_user){
                    try{
                        $reserva= Reserva::find($id);
                        if(isset($reserva)){ 
                            $reserva->delete();
                            return redirect('/reservas')->with('msg', 'Sua reserva foi cancelada!'); 
                            }
                        return redirect('/reservas')->withErrors('Erro: Não foi possível cancelar a reserva');
                    }catch(\Exception $e){ //caso remoção de erro no banco
                        return redirect('/reservas')->withErrors('Erro: Não foi possível cancelar a reserva');
                    }
                }
            }
            return redirect('/reservas'); //caso tentar burlar o delete
        }catch(\Exception $e){ //caso o admin seja inválido
            return redirect('/reservas');
        }
    }
}
