<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Voto;
use App\Topico;
class VotosC extends Controller
{
    //

    public function votar($id){

        $top = Topico::find($id);
        $top->votos++;
        $top->save();

        $voto = new Voto();
        $voto->id_author = Auth::user()->id;
        $voto->id_post = $id;
        $voto->save();
        return redirect('/forum');

    }
}
