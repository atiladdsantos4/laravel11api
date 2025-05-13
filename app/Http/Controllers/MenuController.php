<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Escopo;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function api(Request $request){
    
        $validateUser = Validator::make($request->all(), 
        [
            'page' => 'required|integer',
            'limit' => 'required|integer',
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

       

        $menu_teste = new Menu();
        $count = Menu::count();
        $ini = $request->get('page');
        $limit = $request->get('limit');
        $offset = $limit * $ini;
        $menus = Menu::offset($offset)->limit(10)->get();
        foreach ($menus as $menu) {
           $menu->escopoApi;
           $menu->menupaiApi;
           
           //$menu->appends('attribute');
        }
        $arr_result = [
           "Total de Registros" => $count,
           "Page" => $ini,
           "Limit" => $limit,
           "Resultados" => $menus
        ];
        
        return json_encode($arr_result,JSON_PRETTY_PRINT);  
        //$arr_result->toJson(JSON_PRETTY_PRINT);
        //json_encode($menus,JSON_PRETTY_PRINT);  
    }    

    public function index(){
        /*
        $menu_teste = new Menu();
        $count = Menu::count();
        $ini = $request->get('page');
        $limit = $request->get('limit');
        $offset = $limit * $ini;
        $menus = Menu::offset($offset)->limit(10)->get();
        foreach ($menus as $menu) {
           $menu->escopoApi;
           $menu->menupaiApi;
           
           //$menu->appends('attribute');
        }
        */
        $sql = "select * from ( 
                    select * from (
                        select m.*,
                        e.esc_title as menu_escopo,
                        null as menu_nome_pai,
                        men_id as nivel from men_menu m,esc_escopo e
                        where m.men_id_esc = e.esc_id_esc 
                        and cast(m.men_filho as integer) = 0
                        order by men_id
                    ) a
                union
                    select * from (
                        select m.*,
                        e.esc_title as menu_escopo,
                        (select me.men_name from men_menu me where men_id = m.men_filho_pai) as menu_nome_pai,
                        men_filho_pai as nivel from men_menu m, esc_escopo e
                        where m.men_id_esc = e.esc_id_esc 
                        and cast(m.men_filho as integer) = 1 
                        order by men_filho_pai
                    ) b
                ) c
                order by c.nivel,c.men_filho asc,c.men_filho_position";
        $men = DB::select($sql); 
        return view('menu.index',[ "lista" => $men ]);
    } 

    public function novo(){
        $menu = new Menu; 
        $menus = Menu::ListaMenus();
        $scope = Escopo::getEscopos();  
        $esc = $menu->orderByRaw('men_id_esc,men_id asc')->get();
        $data = [
            "lista" => $esc, 
            "escopo" => $scope, "menu" => $menus,
            "interface"=> 'novo'
        ];
        //return view('menu.novo',[ "lista" => $esc, "escopo" => $scope, "menu" => $menus ]);
        return view('menu.novo',$data);
          
    }

    public function save(Request $request){
        try {
            $all = $request->Post();
            DB::beginTransaction();
            $men = new Menu();
            $request->request->remove('men_data_criacao');
            $achou  = $men->create($request->all());
            DB::commit();
            Session::flash('message', 'Novo Menu inserido com Sucesso!!!' ); 
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

    public function editar($id){
        $menus = Menu::ListaMenus();
        $scope = Escopo::getEscopos();  
        $dados = Menu::where("men_id","=",$id)->first();
        return view('menu.editar',[ "dados" => $dados, "escopo" => $scope, "menu" => $menus ]);
    }

    public function edit($id,Request $request){
        try {
            $all = $request->Post();
            DB::beginTransaction();
            $request->request->remove('men_data_criacao');
            $men = new Menu();
            $men->find($id)->update($request->Post());
            DB::commit();
            Session::flash('message', 'Menu Alterado com Sucesso!!!' ); 
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
            $id = $request->post("men_id"); 
            $men = Menu::find($id)->delete();
            DB::commit();
            Session::flash('message', 'Menu excluído com Sucesso!!!' ); 
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

}
