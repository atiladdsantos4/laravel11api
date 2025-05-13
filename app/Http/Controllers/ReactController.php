<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReactController extends Controller
{
    public function index($id){
       
       $index = $id;   

       switch($index){

         case 0:
            return view('react.intro');
         break;     
         
         case 1:
            return view('react.example01');
         break;     

       }
    }   
}
