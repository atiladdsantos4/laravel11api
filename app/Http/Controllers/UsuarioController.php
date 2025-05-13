<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Http\Helpers\SSP;
use Illuminate\Support\Facades\Validator;
use LaravelLegends\PtBrValidator\Rules\FormatoCpf;
use App\Rules\EscopoCustomRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use App\Mail\TestMail;
use App\Mail\ResetMail;
use Mail;
use Illuminate\Support\Str;

 
class UsuarioController extends Controller
{

    //use  Notifiable;

    public function submitResetPasswordForm(Request $request)
    {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
          
          Session::flash('message', 'Senha Alterada com Sucesso!!!'); 
          Session::flash('bg', 'bg-gradient-success' );    
          return redirect()->back(); 
  
          //return redirect('/login')->with('message', 'Your password has been changed!');
    }

    public function email(Request $request){
        
        $request->validate(
            [
              //'email' => 'required|email'
              'email' => 'required|email|exists:users',
            ]
        );

        $token = Str::random(64);

        
        $user = User::where("email",$request->post('email'))->first(); 
        
        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        // Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
        //     $message->to($request->email);
        //     $message->subject('Reset Password');
        // });
               
        try {

            $mailData = [
                'title' => 'Laravel 11 Reset Password',
                'subject' => 'Link para reset de senha',
                'usuario' => $user->name,
                'email' => $user->email,
                'token' => $token,
            ];

            $test = Mail::to($user->email)->send(new ResetMail($mailData));
            Session::flash('message', 'Email enviado Com sucesso!!!' ); 
            Session::flash('bg', 'bg-gradient-success' );    
            return redirect()->back();  
            //Notification::send($user, new ResetPassword($messages));
            //$valor = $user->notify(new ResetPassword($messages));

        } catch(\Illuminate\Database\QueryException $ex){ 
           $teste = $ex;
        }


        //return back()->with('message', 'We have e-mailed your password reset link!');

        return;
        //User::find(2);
        //$mail = $user->email;
        $path =  asset('storage/curriculo.pdf');
        $messages["hi"] = "Hey, Happy Birthday {$user->name}";
        $messages["wish"] = "On behalf of the entire company I wish you a very happy birthday and send you my best wishes for much happiness in your life.";
       
        try {

            $mailData = [
                'title' => 'Laravel 11 Reset Password',
                'subject' => 'This is a Subject Attach file new',
                'usuario' => $user->name,
                'files' => [
                      asset('attach/curriculo.pdf')
                ]
                // 'files' => [
                //     public_path('attachments/test_image.jpeg'),
                //     public_path('attachments/test_pdf.pdf'),
                // ]
            ];

            $test = Mail::to($user->email)->send(new TestMail($mailData));
            //Notification::send($user, new ResetPassword($messages));
           //$valor = $user->notify(new ResetPassword($messages));

        } catch(\Illuminate\Database\QueryException $ex){ 
           $teste = $ex;
        }    
    }
    
    public function resetPassword(Request $request){
        // $request->validate([
        //     'email' => 'required|email|exists:users',
        //     'password' => 'required|string|min:6|confirmed',
        //     'password_confirmation' => 'required'
        // ]);
        
        return view('sb.reset-password',["email" => $request->get('email'), "token" => $request->get('token')]);
    }
    
    public function api(Request $request){
        $menu_teste = new User();
        $count = User::count();
        $ini = $request->get('page');
        $limit = $request->get('limit');
        $offset = $limit * $ini;
        $escopos = User::offset($offset)->limit(10)->get();
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
        $esc = User::orderBy("email")->get();
        //return view('datatables',[ "lista" => $esc ]);
        return view('usuario.index',[ "lista" => $esc ]);
          
    }

    public function novo(Request $request){
        $esc = User::orderBy("email")->get();
        return view('usuario.novo',[ "lista" => $esc ]);
          
    }
    
    public function editar($id){
        $esc = User::where("esc_id_esc","=",$id)->first();
        return view('usuario.editar',[ "esc" => $esc ]);
    }

    public function edit(Request $request){
        try {
            $all = $request->Post();
            DB::beginTransaction();
            $esc = new User();
            $esc->find($request->Post('esc_id_esc'))->update($request->Post());

            DB::commit();
            Session::flash('message', 'User alterado com Sucesso!!!' ); 
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
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            // //Validated
            // $validateUser = Validator::make($request->all(), 
            // [
            //     'name' => 'required',
            //     'email' => 'required|email|unique:users,email',
            //     'password' => 'required'
            // ]);
            
            // if($validateUser->fails()){
            //     $msg  = $validateUser->errors();
            //     //Session::flash('message', $msg ); 
            //     //Session::flash('bg', 'bg-gradient-danger' ); 
            //     return redirect()->back();  
            //     /*
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'validation error',
            //         'errors' => $validateUser->errors()
            //     ], 401);
            //     */
            // }
            /*
            Session::flash('message', $msg ); 
            Session::flash('bg', 'bg-gradient-danger' ); 
            return redirect()->back();  
            */ 
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token  = $user->createToken("API TOKEN")->plainTextToken;
            // $esc = new User();
            // $esc->create($request->all());
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
            Session::flash('message', 'Usuario criado com Sucesso!!!' ); 
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
            $esc = User::find($id)->delete();
            DB::commit();
            Session::flash('message', 'User excluído com Sucesso!!!' ); 
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
            $esc = new User();
            $esc->create($request->all());
            DB::commit();
            $response = response()->json([
                'status' => 200,  
                'message' => 'User salvo com Sucesso!!!',
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

    public function generatePwd(Request $request){
       $all = $request->Post();
        if(!Auth::attempt($request->only(['email', 'password']))){
            $response =[
               'status' => false,
               'message' => 'Email & Password não encontrados em nossa base.',
            ];
            echo json_encode($response);
            return;
        }

       $user = User::where('email', $request->Post('email'))->first();
       //User::where("email",$request->Post('email'))->get();
       $token  = $user->createToken("API TOKEN")->plainTextToken;
       $response =[
         'status' => true,
         'token' => $token
       ];
       echo json_encode($response);
       return;
       //return;   

    }

    public function resetSenha(Request $request){
        try {
            $all = $request->Post();

            $request->validate([
                'email' => 'required|email',
            ]);

        }  catch(\Illuminate\Database\QueryException $ex){ 
        
        }
    }        
}

