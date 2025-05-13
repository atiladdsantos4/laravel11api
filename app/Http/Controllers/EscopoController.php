<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escopo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Http\Helpers\SSP;
use Illuminate\Support\Facades\Validator;
use LaravelLegends\PtBrValidator\Rules\FormatoCpf;
use App\Rules\EscopoCustomRule;

class EscopoController extends Controller
{

    public function api(Request $request){
        $menu_teste = new Escopo();
        $count = Escopo::count();
        $ini = $request->get('page');
        $limit = $request->get('limit');
        $offset = $limit * $ini;
        $escopos = Escopo::offset($offset)->limit(10)->get();
        /*foreach ($menus as $menu) {
           $menu->escopoApi;
           $menu->menupaiApi;
           
           //$menu->appends('attribute');
        }*/
        $arr_result = [
           "Total de Registros" => $count,
           "Page" => $ini,
           "Limit" => $limit,
           "Resultados" => $escopos
        ];
        
        return json_encode($arr_result,JSON_PRETTY_PRINT);  
        //$arr_result->toJson(JSON_PRETTY_PRINT);
        //json_encode($menus,JSON_PRETTY_PRINT);  
    }
    public function index(Request $request){
        $esc = Escopo::orderBy("esc_posicao")->get();
        //return view('datatables',[ "lista" => $esc ]);
        return view('escopo.index',[ "lista" => $esc ]);
          
    }

    public function novo(Request $request){
        $esc = Escopo::orderBy("esc_posicao")->get();
        return view('escopo.novo',[ "lista" => $esc ]);
          
    }
    
    public function editar($id){
        $esc = Escopo::where("esc_id_esc","=",$id)->first();
        return view('escopo.editar',[ "esc" => $esc ]);
    }

    public function edit(Request $request){
        try {
            $all = $request->Post();
            DB::beginTransaction();
            $esc = new Escopo();
            $esc->find($request->Post('esc_id_esc'))->update($request->Post());

            DB::commit();
            Session::flash('message', 'Escopo alterado com Sucesso!!!' ); 
            Session::flash('bg', 'bg-gradient-success' ); 
            return redirect()->back();  
         }
         catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $msg = $ex->getMessage(); 
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  
        }     
    }

    /*
    DB::table('ent_entradas')->where( 'ent_id_ent',$request->get('ent_id_ent'))
        ->update(
              array(
                "ent_id_rec" => $request->get('ent_id_rec'),
                "ent_id_doc" => $request->get('ent_id_doc'),
                "ent_num_doc" => $request->get('ent_num_doc'),
                "ent_data_doc" => $request->get('ent_data_doc'),
                "ent_doc_valor" => $valor,
               )
            );  
    */

    public function save(Request $request){
        try {
            $all = $request->Post();

            $request->validate([
                'esc_title' => 'unique:esc_escopo|required|max:200',
                'esc_posicao' => ['numeric',new EscopoCustomRule],
            ]);

            DB::beginTransaction();
            $esc = new Escopo();
            $esc->create($request->all());
            /*DB::table('esc_escopo')->insert(
                array(
                    "esc_posicao" => $request->get('esc_posicao'),
                    'updated_at' => Carbon::createFromFormat('d/m/Y H:i:s', $request->get('created_at'))->format('Y-m-d H:i:s'),
                    "ent_data_doc" => $request->get('ent_data_doc'),
                    "ent_doc_valor" => $valor,
                 )
            );
            */
            DB::commit();
            Session::flash('message', 'Escopo salvo com Sucesso!!!' ); 
            Session::flash('bg', 'bg-gradient-success' ); 
            return redirect()->back();
        }
        catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $msg = $ex->getMessage(); 
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  
        }

          
    }

    public function delete(Request $request){
        try {
            DB::beginTransaction();
            $id = $request->post("esc_id_esc"); 
            $esc = Escopo::find($id)->delete();
            DB::commit();
            Session::flash('message', 'Escopo excluído com Sucesso!!!' ); 
            Session::flash('bg', 'bg-gradient-success' ); 
            return redirect()->back();
        }
        catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $msg = $ex->getMessage(); 
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  
        }
        
    }

    public function SaveApi(Request $request){

        $all = file_get_contents('php://input'); //get from other source 
        
        $validator = Validator::make($request->all(), [
            'esc_title' => 'unique:esc_escopo|required|max:200',
            'esc_posicao' => ['numeric',new EscopoCustomRule],
            //'cpf'  => ['required', new FormatoCpf]

        ]);

        if ($validator->fails()) {
             $errors = $validator->errors();
             $response = response()->json([
                'message' => 'Erros Encontrados',
                'details' => $errors->messages(),
             ], 422);

            return $response;
        }

        try{

            DB::beginTransaction();
            $esc = new Escopo();
            $esc->create($request->all());
            DB::commit();
            $response = response()->json([
                'status' => 200,  
                'message' => 'Escopo salvo com Sucesso!!!',
            ], 200);
            return $response;

        }  catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $msg = $ex->getMessage(); 
            $response = response()->json([
                'message' => 'Erros Encontrados',
                'details' => $msg,
            ], 422);

            return $response;
        }

    }
}

