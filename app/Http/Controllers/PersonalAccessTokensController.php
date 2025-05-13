<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalAccessTokens;

class PersonalAccessTokensController extends Controller
{
    public function index(Request $request,$id = null){
        // $id = 4;
        // $token = new PersonalAccessTokens();
        // $user = $token->find($id); 
        // $user->user();
        // return $user->user->name; 
        $esc = PersonalAccessTokens::orderBy("tokenable_id")->get();
        if( $id != null){
           return view('usuario.index_token',[ "lista" => $esc, "campo" => "tokenable_id", "id"=> $id]);
        } else {
           return view('usuario.index_token',[ "lista" => $esc,"id"=> null]);  
        } 
        
        
          
    }
}
