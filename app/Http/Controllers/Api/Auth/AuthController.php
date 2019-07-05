<?php
namespace App\Http\Controllers\Api\Auth;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class AuthController extends Controller {
    // vamos definir o retorno caso sucesso ou falha
    private $successStatusCode = 200;
    private $failStatusCode = 401;
    
    
    // rgistrarndo o usuário
    public function register(Request $request) {    
       $validator = Validator::make($request->all(), [ 
             'name' => 'required',
             'email' => 'required|email',
             'password' => 'required'
           ]);   
       if ($validator->fails()) {
           
           return response()->json(['error'=>$validator->errors()], $this->failStatusCode);                     
       }    
       $input = $request->all();  
       $input['password'] = bcrypt($input['password']);
       $user = User::create($input); 
       $success['token'] =  $user->createToken('AppName')->accessToken;

       return response()->json(['success'=>$success], $this->successStatus); 
   }


   public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
           $user = Auth::user(); 
           $success['token'] =  $user->createToken('AppName')-> accessToken; 
           
           return response()->json(['success' => $success], $this-> successStatusCode); 
        } else { 
            
           return response()->json(['error'=>'Unauthorised'], $this->failStatusCode); 
        } 
   }

   public function getUser() {
       $user = Auth::user();
       
       return response()->json(['success' => $user], $this->successStatusCode); 
   }
} 