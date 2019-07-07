<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Validator;

use App\User; 
use App\Role;

class AuthController extends Controller
{
    //retorno caso sucesso ou falha
    private $successStatusCode = 200;
    private $failStatusCode = 401;
    
    
    /*
     * Registrar: params: email e senha
     * 
     * @params request ref $validator
     * 
     * @return json status 
     */
    public function register(Request $request) 
    {    
        //validações
        $validator = Validator::make($request->all(), [ 
             'name' => 'required|max:50',
             'email' => 'required|email',
             'password' => 'required|min:5|max:100'
        ]); 
       
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->failStatusCode);                     
        }    
       
       $requestData = $request->all();  
       $requestData['password'] = bcrypt($requestData['password']);
       
       // criar usuario
       $user = User::create($requestData); 
       $tokenData['token'] =  $user->createToken('App')->accessToken;
       // anexar a role basica
       $user->roles()->attach(Role::where('name', 'basic')->first());
       
       return response()->json(['data'=>$tokenData], $this->successStatusCode); 
    }

    /*
     * GET login
     * 
     * @params request ref $validator
     * 
     * @return  json ? token : falha
     */ 
    public function login(Request $request) 
    { 
        //validações
        $validator = Validator::make($request->all(), [ 
             'email' => 'required|email',
             'password' => 'required|min:5'
        ]); 
       
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->failStatusCode);                     
        }    
       
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
           $user = Auth::user(); 
           $success['token'] =  $user->createToken('App')-> accessToken;            
           return response()->json(['data' => $success], $this-> successStatusCode); 
        } 
        else 
        { 
           return response()->json(['data'=>'Unauthorised'], $this->failStatusCode); 
        } 
    }
}
