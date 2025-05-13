<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): string
    {
        //return view('sb/page_login');
        return view('sb.page_login');
    }

    public function login(Request $request){
        session_start(); 
        $all = $request->all();
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $email = trim($request->get('email'));
        $senha = $request->get('password');

        if(!Auth::attempt($request->only(['email', 'password']))){
           
            $msg = 'Usuário ou senha inválidos';
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  

        }

        $login = User::whereRaw("trim(email) ="."'".trim($request->get('email'))."'")->get();
        /*
        $login = Usuario::whereRaw("trim(usr_mail) ="."'".trim($request->get('email'))."'")
        ->whereRaw("trim(usr_passwd)63 ="."'".md5( trim( $request->get('password')))."'")
        ->whereRaw("usr_delete = '0'")
        ->whereRaw("usr_ativo = '1'")
        ->get();
        */
        //$login = User::where('email','=',$request->get('email'))->get();
        if( isset($login[0]["email"]) ){
            session(['username' => $login[0]["name"]]);
            session(['usermail' => $login[0]["email"]]);
            return view('sb.template',[ "user" => $login]); 
        } else {
            $msg = 'Usuário ou senha inválidos';
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  
        }  
     }

     public function loginApi(Request $request){
        $all = $request->all();
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $email = trim($request->get('email'));
        $senha = $request->get('password');

        if(!Auth::attempt($request->only(['email', 'password']))){
           
            $msg = 'Usuário ou senha inválidos';
            $response = [
                'status' => false,
                'message' => 'Usuário ou senha inválidos'
            ];
            return $response; 

        }

        //$login = User::whereRaw("trim(email) ="."'".trim($request->get('email'))."'")->get();
        $login = User::where('email', $request->email)->first();
        /*
        $login = Usuario::whereRaw("trim(usr_mail) ="."'".trim($request->get('email'))."'")
        ->whereRaw("trim(usr_passwd)63 ="."'".md5( trim( $request->get('password')))."'")
        ->whereRaw("usr_delete = '0'")
        ->whereRaw("usr_ativo = '1'")
        ->get();
        */
        //$login = User::where('email','=',$request->get('email'))->get();
        if( isset($login->email) ){
            session(['username' => $login->name]);
            session(['usermail' => $login->email]);
            $msg = 'Usuário ou senha inválidos';
            $response = [
                'status' => true,
                'id' => $login->id,
                'username' => $login->name,
                'mail'=> $login->email,
                'token' => $login->createToken("API TOKEN")->plainTextToken
            ]; 
            return json_encode($response,JSON_PRETTY_PRINT);
        } else {
            $msg = 'Usuário ou senha inválidos';
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  
        }  
     }

}
