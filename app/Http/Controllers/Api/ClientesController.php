<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Cliente;
use App\Http\Resources\ClienteResource;
use GuzzleHttp\Client;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Include trashed records when retrieving results...(softDeletes)
        //--> $orders = Order::search('Star Trek')->withTrashed()->get();
        // Only include trashed records when retrieving results...
        //--> $orders = Order::search('Star Trek')->onlyTrashed()->get();
        
        $clientes = Cliente::orderBy('cli_id')->get();
        //$products = Product::all();
        $arr_result = [
            "Lista de Clientes" => $clientes
        ];

        $result =  ClienteResource::collection($clientes); //only works for colection     
        
        $response = [
            'success' => true,
            'message' => 'Lista de Clientes',
            'data'    => $result
        ];
  
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //POST api/product
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'cli_name' => 'required',
            'cli_type' => 'required',
            'cli_cpf_cnpj' => 'required',
            'cli_ativo' => 'required',
        ]);
   
        if($validator->fails()){
            $teste = $validator->errors();
            if ($validator->fails())  {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            //return json_encode(['error'=>$validator->errors()]); 
            //return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = Cliente::create($input);

        $arr_result = [
            "status" => true,
            "mensagem" => "Cliente Inserido com sucesso!!!",
            "data" => $product
        ];
         
        return json_encode($arr_result,JSON_PRETTY_PRINT); 
    }

    /**
     * Display the specified resource.
     */
    public function show($id): String //GET api/products/{param}?valor1=1&valor2...
    {
        $cliente = Cliente::find($id);
        //$result =  ProductResource::collection($product); 
  
        if (is_null($cliente)) {
            
            $arr_result = [
                "Cliente não encontrado" => "Cod: ".$id
            ];
            //return $this->sendError('Product not found.');
        } else {

            $arr_result = [
                "status"=> true,
                "mensagem" => "Produto Encontrado",
                "data" => $cliente
            ];
        }
        
         
        return json_encode($arr_result,JSON_PRETTY_PRINT); 
        //return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    public function update(Request $request, Cliente $cliente): String //PUT api/products/{param}?valor1=1&valor2...
    {
        /*Obs: 
           Para o updated_at se incluso ou alterado algum moficação deve ser feita 
           o timestamps do mole igual true
        */
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'cli_name' => 'required',
            'cli_type' => 'required',
            'cli_cpf_cnpj' => 'required',
            'cli_ativo' => 'required',
        ]);
   
        if ($validator->fails())  {
            return response()->json(['error'=>$validator->errors()], 401);
        }
   
        $cliente->cli_name = $input['cli_name'];
        $cliente->cli_type = $input['cli_type'];
        $cliente->cli_cpf_cnpj = $input['cli_cpf_cnpj'];
        $cliente->cli_ativo = $input['cli_ativo'];
        $cliente->update();

        
        $arr_result = [
             "Cliente Atualizado" => $cliente
        ];
      
        
        return json_encode($arr_result,JSON_PRETTY_PRINT); 
        //return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente): String
    {
        $cliente->delete();

        $arr_result = [
            "Cliente Excluído com Sucesso" => $cliente
        ];

        return json_encode($arr_result,JSON_PRETTY_PRINT);
   
        //return $this->sendResponse([], 'Product deleted successfully.');
    }
}
