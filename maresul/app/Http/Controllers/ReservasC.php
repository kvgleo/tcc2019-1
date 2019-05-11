<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Reserva;
use Carbon\Carbon;

class ReservasC extends Controller{


    public function index(){
        
        try{
            $auth= Auth::user()->isAdmin;
            if($auth==true){ //retornar view para admin
                $reservas = DB::table('reservas') //consulta principal
                ->join('users', 'users.id', '=', 'reservas.id_user',)
                ->select('reservas.*', 'users.*','reservas.id','reservas.created_at')->orderBy('reservas.created_at', 'desc')->get();
        
                $conc = DB::table('reservas') //consultas para gráficos
                ->select(DB::raw('count(*) AS num'))->where('reservas.reportdate', '<', now())->get();
        
                $pen = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->where('reservas.reportdate', '>', now())->get();
        
                $quadra = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->where('reservas.local_targ', '=', 'quadra')->get();
        
                $patio = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->where('reservas.local_targ', '=','patio')->get();
        
                $salao1 = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->where('reservas.local_targ', '=', 'sfestas1')->get();
        
                $salao2 = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->where('reservas.local_targ', '=', 'sfestas2')->get();
        
                $fim = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->whereDate('reservas.reportdate', '=', now())->get();
        
                $inicio = DB::table('reservas')
                ->select(DB::raw('count(*) AS num'))->whereDate('reservas.created_at', '=', now())->get();
        
        
                return view('adm.reservas',compact('reservas','conc','pen','quadra','patio','salao1','salao2','fim','inicio'));

                 
            }else{ //retornar view para usuario
                $reservas = DB::table('reservas')
                ->join('users', 'users.id', '=', 'reservas.id_user',)
                ->select('reservas.*', 'users.*','reservas.id','reservas.created_at')->orderBy('reservas.created_at', 'desc')->get();
        
                return view('reservas',compact('reservas'));

            }
        }catch(\Exception $e){ //burlar acesso redireciona para página de login

            return redirect('/login');
        } 
    }

    public function store(Request $request){
        
        if($request->input('dia')==null){
            return redirect('/reservas')->with('avs','Data Inválida');
        }
        try{
        $reserva = new Reserva();
        $reserva->reportdate= $request->input('dia');
        $reserva->id_user=  Auth::user()->id;
        $reserva->local_targ= $request->input('local');
        $reserva->save();
        return  redirect('/reservas')->with('msg', 'Sua reserva foi adicionada!');

        }catch(\Exception $e){ //burlar acesso redireciona para página de login

        return redirect('/reservas')->with('avs', 'Já existe uma reserva para o mesmo dia');
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
                        return redirect('/reservas')->with('msg', 'Sua reserva foi ancelada!');
                        } 
                    return redirect('/reservas')->with('avs', 'Não foi possível cancelar a reserva');
                }catch(\Exception $e){ //caso remoção de erro no banco
                    return redirect('/reservas')->with('avs', 'Não foi possível cancelar a reserva');
                }
            }else{
                if(Auth::user()->id==$id_user){
                    try{
                        $reserva= Reserva::find($id);
                        if(isset($reserva)){ 
                            $reserva->delete();
                            return redirect('/reservas')->with('msg', 'Sua reserva foi cancelada!'); 
                            }
                        return redirect('/reservas')->with('avs', 'Não foi possível cancelar a reserva');
                    }catch(\Exception $e){ //caso remoção de erro no banco
                        return redirect('/reservas')->with('avs', 'Não foi possível cancelar a reserva');
                    }
                }
            }
            return redirect('/reservas'); //caso tentar burlar o delete
        }catch(\Exception $e){ //caso o admin seja inválido
            return redirect('/reservas');
        }
    }
}
