<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginAdminC extends Controller{

    public function __construct(){
        $this->middleware('guest:admin');
    }

    public function index(){
        return view("auth.login_admin");
    }


    public function login(Request $request){

        $this->validate($request,[ //validar se os campos foram preenchidos corretamente
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin_card = [ //armazenar credencias digitadas
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $authOk = Auth::guard('admin')->attempt($admin_card, $request->remember); //fazer tentativa de login
        

        if($authOk){
        return redirect()->intended(route('admin_home')); //redirecionar para home admin
        }

        return redirect()->back()->withInputs($request->only('name'))->withErrors('credenciais incorretas'); //retornar a pagina com erros

    }
    
}
