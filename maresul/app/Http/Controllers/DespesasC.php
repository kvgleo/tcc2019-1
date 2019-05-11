<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Despesa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use App\Lancamento;
use App\User;

class DespesasC extends Controller
{
    public function index(){

        $lancamentos = DB::table('lancamentos')->orderBy('created_at','desc')->get();

        return view('adm.despesas', compact('lancamentos'));
  
    }


    public function store(Request $request){ //criar novo anuncio

        $lanc = new Lancamento();

        $lanc->reportdate= $request->input('reportdate');
        $lanc->lanc_desc= $request->input('desc');
        $lanc->valor= $request->input('valor');
        $lanc->tipo= $request->input('tipo');

        switch($request->input('tipo')){
            case 'Pessoal':
                $lanc->info_tipo = "Pagamentos de salarios e encargos, cumprimento da legislação trabalhista e benefícios (VT e VA e Seguro Saúde)";
                break;
            case 'Concessionárias':
                $lanc->info_tipo = "Contas de água, luz, gás etc";
                break;
            case 'Obras':
                $lanc->info_tipo = "Contratos de bombas, elevadores, geradores, manutenções diversas, academia, piscina e compra de materiais";
                break;
            case 'Administrativo':
                $lanc->info_tipo = "Despesas bancárias, contratação de seguros e despesas administrativas";
                break;
            case 'Reserva':
                $lanc->info_tipo = "Poupança para despesas não previstas";
                break;
            case 'Síndico':
                $lanc->info_tipo = "Investimentos e circulação das ações da aplicação sindical";
                break;                
        }

        $lanc->save();
        return  redirect('/despesas')->with('msg', 'Novo lançamento adicionado!');
    }

    public function update(Request $request, $id, $ano){

        $lanc = Lancamento::find($id);
        try{
            $lanc->reportdate= $request->input('datEdit');
            $lanc->lanc_desc= $request->input('descEdit');
            $lanc->valor= $request->input('valEdit');
            $lanc->tipo= $request->input('tipoEdit');
            switch($request->input('tipoEdit')){
                case 'Pessoal':
                    $lanc->info_tipo = "Pagamentos de salarios e encargos, cumprimento da legislação trabalhista e benefícios (VT e VA e Seguro Saúde)";
                    break;
                case 'Concessionárias':
                    $lanc->info_tipo = "Contas de água, luz, gás etc";
                    break;
                case 'Obras':
                    $lanc->info_tipo = "Contratos de bombas, elevadores, geradores, manutenções diversas, academia, piscina e compra de materiais";
                    break;
                case 'Administrativo':
                    $lanc->info_tipo = "Despesas bancárias, contratação de seguros e despesas administrativas";
                    break;
                case 'Reserva':
                    $lanc->info_tipo = "Poupança para despesas não previstas";
                    break;
                case 'Síndico':
                    $lanc->info_tipo = "Investimentos e circulação das ações da aplicação sindical";
                    break;                
            }
            $lanc->save();
            
            $url = URL::route('historico', ['ano' => $ano]);
            return \Redirect::to($url)->with('msg','Registro de'.$ano.' alterado!');

        }catch(\Exception $e){
            $url = URL::route('historico', ['ano' => $ano]);
            return \Redirect::to($url)->with('avs','Não foi possivel alterar este registro!');
        }  
        return  redirect('/historico');
    }

    public function historico_red(){ //ao clicar na aba historico a função retorna uma consulta com os anos e redireciona o ultimo ano cadastrado para a rota historico;

        $anos = Lancamento::select(DB::raw('YEAR(reportdate) as ano'))->orderBy('reportdate','desc')->distinct()->first();
        if($anos == null){
            return view('adm.hist_null');
        }else{
            $url = URL::route('historico', ['ano' => $anos->ano]);
            return \Redirect::to($url);
        }
    }

    public function historico($ano){ //precisa de um ano para ser exibido o historico;

        $anos = Lancamento::select(DB::raw('YEAR(reportdate) as ano'))->distinct()->orderBy('reportdate','desc')->get();

        $meses = Lancamento::select(DB::raw('month(reportdate) as mesl'))->distinct()->whereYear('reportdate','=',$ano)->orderBy('reportdate','asc')->get();

        $lancamentos = Lancamento::select(DB::raw("sum(valor)AS valor,tipo,month(reportdate) as mes,reportdate as dia,lanc_desc,info_tipo"))->whereYear('reportdate','=',$ano)->groupBy(DB::raw('month(reportdate), tipo','desc'))->get();

        $all = Lancamento::select(DB::raw('*'))->whereYear('reportdate', '=', $ano)->orderBy('created_at','desc')->get();

        $as= Lancamento::select(DB::raw('sum(valor) AS sind'))->where('tipo','like','Síndico')->whereYear('reportdate', '=', $ano)->get();

        $conc= Lancamento::select(DB::raw('sum(valor) AS conc'))->where('tipo','like','Concessionárias')->whereYear('reportdate', '=', $ano)->get();

        $adm= Lancamento::select(DB::raw('sum(valor) AS adm'))->where('tipo','like','Administrativo')->whereYear('reportdate', '=', $ano)->get();

        $fundo= Lancamento::select(DB::raw('sum(valor) AS fundo'))->where('tipo','like','Reserva')->whereYear('reportdate', '=', $ano)->get();

        $pes= Lancamento::select(DB::raw('sum(valor) AS pes'))->where('tipo','like','Pessoal')->whereYear('reportdate', '=', $ano)->get();

        $ccmi= Lancamento::select(DB::raw('sum(valor) AS ccmi'))->where('tipo','like','Obras')->whereYear('reportdate', '=', $ano)->get();


        return view('adm.historico', compact('anos','lancamentos','meses','all','as','conc','adm','fundo','pes','ccmi'));
        
        }

        public function est(){

            $ano = Lancamento::select(DB::raw('YEAR(reportdate) as ano'))->distinct()->orderby('reportdate','desc')->first();

            if($ano == null){
                return view('adm.est_null');
            }else{
                $anoc = (int) $ano->ano;

                $ano2 = Lancamento::select(DB::raw('YEAR(reportdate) as ano'))->distinct()->first();

                $as= Lancamento::select(DB::raw('sum(valor) AS sind'))->where('tipo','like','Síndico')->get();

                $conc= Lancamento::select(DB::raw('sum(valor) AS conc'))->where('tipo','like','Concessionárias')->get();
        
                $adm= Lancamento::select(DB::raw('sum(valor) AS adm'))->where('tipo','like','Administrativo')->get();
        
                $fundo= Lancamento::select(DB::raw('sum(valor) AS fundo'))->where('tipo','like','Reserva')->get();
        
                $pes= Lancamento::select(DB::raw('sum(valor) AS pes'))->where('tipo','like','Pessoal')->get();
        
                $ccmi= Lancamento::select(DB::raw('sum(valor) AS ccmi'))->where('tipo','like','Obras')->get();

                $users = User::select(DB::raw('count(*) AS total'))->get();

                $in = User::select(DB::raw('count(*) AS inp'))->where('inp','=',false)->get();

                $sind = Lancamento::select(DB::raw('sum(valor) AS total'))->where('tipo','like','Síndico')->whereYear('reportdate', '=',$anoc)->get();

                $sind2 = Lancamento::select(DB::raw('sum(valor) AS val, reportdate AS dat'))->where('tipo','=','Síndico')->whereYear('reportdate', '=',$anoc)->groupBy(DB::raw('month(reportdate)'))->orderby('reportdate', 'DESC')->get();

                $res =  Lancamento::select(DB::raw('sum(valor) AS total'))->where('tipo','like','Reserva')->whereYear('reportdate', '=',$anoc)->get();

                $res2 = Lancamento::select(DB::raw('sum(valor) AS val, reportdate AS dat'))->where('tipo','=','Reserva')->whereYear('reportdate', '=',$anoc)->groupBy(DB::raw('month(reportdate)'))->orderby('reportdate', 'DESC')->get();
                
                $res3 = Lancamento::select(DB::raw('sum(valor) AS val, month(reportdate) AS mes'))->where('tipo','=','Reserva')->whereYear('reportdate', '=',$anoc)->groupBy(DB::raw('month(reportdate)'))->orderby('reportdate', 'ASC')->get();

                $sind3 = Lancamento::select(DB::raw('sum(valor) AS val, month(reportdate) AS mes'))->where('tipo','=','Síndico')->whereYear('reportdate', '=',$anoc)->groupBy(DB::raw('month(reportdate)'))->orderby('reportdate', 'ASC')->get();

                $sind3 = Lancamento::select(DB::raw('sum(valor) AS val, month(reportdate) AS mes'))->where('tipo','=','Síndico')->whereYear('reportdate', '=',$anoc)->groupBy(DB::raw('month(reportdate)'))->orderby('reportdate', 'ASC')->get();

                $mconc = Lancamento::select(DB::raw('*'))->where('tipo','=','Concessionárias')->orderby('valor', 'ASC')->get();

                $mccmi = Lancamento::select(DB::raw('*'))->where('tipo','=','Obras')->orderby('valor', 'ASC')->get();

                $madm = Lancamento::select(DB::raw('*'))->where('tipo','=','Administrativo')->orderby('valor', 'ASC')->get();

                $mpes = Lancamento::select(DB::raw('*'))->where('tipo','=','Pessoal')->orderby('valor', 'ASC')->get();

                return view('adm.estatisticas', compact('as','conc','adm','fundo','pes','ccmi', 'users', 'in','sind','sind2','sind3','res','res2','res3','mconc','mccmi','madm','mpes','anoc'));
            }


        }

    public function destroy($id, $ano){ //remover registro e redirecionar para pagina principal.
        $lanc= Lancamento::find($id);
        if(isset($lanc)){ 
           try{
            $lanc->delete(); 
            $url = URL::route('historico', ['ano' => $ano]);
            return \Redirect::to($url)->with('avs','O registro foi removido!');
           }catch(\Exception $e){
            $url = URL::route('historico', ['ano' => $ano]);
            return \Redirect::to($url)->with('avs','Não foi possível remover o item desejado!');
           }
       } 
       return  redirect('/historico');
    }
}
