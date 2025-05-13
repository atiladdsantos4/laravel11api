<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index() //GET api/product
    {
        
        // Include trashed records when retrieving results...(softDeletes)
        //--> $orders = Order::search('Star Trek')->withTrashed()->get();
        // Only include trashed records when retrieving results...
        //--> $orders = Order::search('Star Trek')->onlyTrashed()->get();
        
        $products = Product::orderBy('id')->get();
        //$products = Product::all();
        $arr_result = [
            "Lista de Produtos" => $products
        ];

        $result =  ProductResource::collection($products); //only works for colection     
        
        $response = [
            'success' => true,
            'message' => 'Lista de Produtos',
            'data'    => $result
        ];
  
        return response()->json($response, 200);
        
        //return json_encode($arr_result,JSON_PRETTY_PRINT); 
        //$this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    public function store(Request $request) //POST api/product
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            $teste = $validator->errors();
            if ($validator->fails())  {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            //return json_encode(['error'=>$validator->errors()]); 
            //return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = Product::create($input);
        if($request->hasFile('file')) {
          $file = $request->file('file');
          $fileName  = $file->getClientOriginalName();
          $mime_type = $file->getClientmimeType(); 
          $path = 'images/'.$product->id.'/'.$fileName;
          Storage::disk('public')->put($path, file_get_contents($file)); 
        }  

        $arr_result = [
            "status" => true,
            "mensagem" => "Produto Inserido com sucesso!!!",
            "data" => $product
        ];
         
        return json_encode($arr_result,JSON_PRETTY_PRINT); 
    }

    public function show($id): String //GET api/products/{param}?valor1=1&valor2...
    {
        $product = Product::find($id);
        //$result =  ProductResource::collection($product); 
  
        if (is_null($product)) {
            
            $arr_result = [
                "status"=> false,
                "Produto não encontrado" => "Cod: ".$id
            ];
            //return $this->sendError('Product not found.');
        } else {

            $arr_result = [
                "status"=> true,
                "mensagem" => "Produto Encontrado",
                "data" => $product
            ];
        }
        
         
        return json_encode($arr_result,JSON_PRETTY_PRINT); 
        //return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function teste(Request $request){
      $teste = null;
      return;  
    }
    //public function update(Request $request): String //PUT api/products/{param}?valor1=1&valor2...
    public function update(Request $request, Product $product): String //PUT api/products/{param}?valor1=1&valor2...
    {
        /*Obs: 
           Para o updated_at se incluso ou alterado algum moficação deve ser feita 
           o timestamps do mole igual true
        */
        $input = $request->all();

        //para atualização de imagem apenas//
        if( $request->has('only_image') ) {

           $file = $request->file('file');

           $validator = Validator::make($input, [
               'file' => 'nullable|image|mimes:jpeg,jpg,png,gif',
           ]);

           if ($validator->fails())  {
                $valor =  $validator->errors()->get('*');
                $error = [
                'status' => false,
                'data' => $valor   
                ];
                return json_encode($error,JSON_PRETTY_PRINT);
           } 
                
          //deleta a imagem antiga se houver // depois transformar em método //  
          $imagem  = $product->imagem;  
          $path = 'images/'.$product->id.'/'.$imagem;
          Storage::disk('public')->delete($path);

          $fileName  = $file->getClientOriginalName();
          $mime_type = $file->getClientmimeType(); 
          $path = 'images/'.$product->id.'/'.$fileName;
          //adiciona a nova imagem e atualiza o conteudo
          Storage::disk('public')->put($path, file_get_contents($file)); 
          
          $product->imagem = $input['imagem']; 
          $product->update();

        
          $arr_result = [
               "mensagem" => $product,
               "data" => $product
          ];
          return json_encode($arr_result,JSON_PRETTY_PRINT); 
        }
       
        try {
            $validator = Validator::make($input, [
                    'name' => 'required',
                    'detail' => 'required',
                    'price' => 'required',
                    'file' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            ]);

            if ($validator->fails())  {
                $valor =  $validator->errors()->get('*');
                $error = [
                  'status' => false,
                  'data' => $valor   
                ];
                return json_encode($error,JSON_PRETTY_PRINT);
                //return response()->json(['error'=>$valor]);
            } 

        } catch (\Illuminate\Validation\ValidationException $ex) {
            $teste = $ex;
            $teste = $ex->getMessage();
            $val =  $validator->errors();
            return null;
        }    
        
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->price = $input['price'];
        

        if($request->hasFile('file')) {
          //deleta a imagem antiga se houver  
          $imagem  = $product->imagem;  
          $path = 'images/'.$product->id.'/'.$imagem;
          Storage::disk('public')->delete($path);

          $file = $request->file('file');
          $fileName  = $file->getClientOriginalName();
          $mime_type = $file->getClientmimeType(); 
          $path = 'images/'.$product->id.'/'.$fileName;
          //adiciona a nova imagem e atualiza o conteudo
          Storage::disk('public')->put($path, file_get_contents($file)); 
          $product->imagem = $input['imagem'];
        } 
        
        $product->update();

        
        $arr_result = [
                "Produto Atualizado" => $product
        ];
      
        
        return json_encode($arr_result,JSON_PRETTY_PRINT); 
        //return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    public function destroy(Product $product): String
    {
        $product->delete();

        $arr_result = [
            "Produto Excluído com Sucesso" => $product
        ];

        return json_encode($arr_result,JSON_PRETTY_PRINT);
   
        //return $this->sendResponse([], 'Product deleted successfully.');
    }
}    
