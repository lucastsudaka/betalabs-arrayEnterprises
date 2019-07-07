<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Comment;
use App\User;

class CurrentUserController extends Controller
{
    private $successStatusCode = 200;
    private $failStatusCode = 401;
    
    /*
     * 
     * GET | Retorna o usuário logado atualmente
     * 
     * 
     */
    public function index() 
    {       
        $user = Auth::guard('api')->user()->makeVisible('email');       
        return response()->json(['data' => $user], $this->successStatusCode); 
    }
   
    /*
     * 
     * PUT | atualiza usuário autenticado atualmente
     * 
     * @param request ref $validadtor
     * 
     */
    public function update(Request $request) 
    {
        $user = Auth::guard('api')->user()->makeVisible('email');       

        //validações
        $validator = Validator::make($request->all(), [ 
             'name' => 'required|max:50',
             'email' => 'required|email|unique:users,email,'.$user->id,
        ]); 
       
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->failStatusCode);                     
        }    
        
        
        $user = Auth::guard('api')->user()->makeVisible('email'); 
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return response()->json(['data' => $user], $this->successStatusCode); 

    }
    
    /*
     * 
     * POST | atualiza a foto de perfil do usuário
     * 
     * @param request file ref $validator
     * 
     * @return json
     * 
     */
    public function uploadPhoto(Request $request){

        $user = Auth::guard('api')->user()->makeVisible('email');       

        //validações
        $validator = Validator::make($request->all(), [ 
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);         
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], $this->failStatusCode);                     
        }    
        
        $photoName = $user->uuid.'_'.uniqid().'.'.request()->photo->getClientOriginalExtension();
        $request->photo->storeAs('user_profile',$photoName);
        $user->photo = $photoName;
        $user->save();
        
        return response()->json(['data' => $user], $this->successStatusCode); 


     }
    
}

