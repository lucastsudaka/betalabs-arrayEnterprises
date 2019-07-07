<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Comment;
use App\User;

class CommentController extends Controller
{
    public function __construct()
    {
     #   $this->middleware('auth:api', ['except' => ['index']]);

    }

    /*
     * GET lista todos os comentários
     * 
     * 
     * @return  json 
     */     
    public function index()
    {
        $comments = Comment::with('history')->with('user')->get();  
        return response()->json(['data'=>$comments]);
    }
    
    
    /*
     * SHOW exibe um comentário
     * 
     * @param ID do comentáriop
     * 
     * @return  json 
     */     
    public function show($id)
    {
        $comments = Comment::with('history')->with('user')->findOrFail($id);  
        return response()->json(['data'=>$comments]);  
    }
    
    
    /*
     * POST salva um novo comentário
     * 
     * @param   request ref $validator 
     * 
     * @return  json 
     */ 
    public function store(Request $request)
    {
        // validação
        $validator = Validator::make($request->all(), [
            'body'    => 'required|max:500',
        ]);  
        if ($validator->fails()) 
        { 
          return response()->json(['errors'=>$validator->errors()]);
        }
        
        // Salvar
        $comment = new Comment();
        $comment->body  = $request->body;
        Auth::guard('api')->user()->comments()->save($comment);

        /// retornando o resultado 
        $returnComment = Comment::with('user')->find($comment->id);
        return response()->json(['data' => $returnComment], 201);
    }
  
    /*
     * PUT atualiza um comentátio
     * 
     * @params request ref $validator
     * @params id do comentário
     * 
     * @return  json 
     */ 
    public function update(Request $request, $id)
    {
        // validação
        $validator = Validator::make($request->all(), [
            'body'    => 'required|max:500',
        ]);  
        if ($validator->fails()) 
        { 
          return response()->json(['data'=>$validator->errors()]);
        }
        
        /// atualizar
        $comment = Auth::guard('api')->user()->comments()->findOrFail($id);
        $comment->body = $request->body;
        $comment->save();
  
        /// retornando o resultado da alteração
        $returnComment = Comment::with('user')->find($comment->id);
        return response()->json(['data' => $returnComment], 201);
    }
  
    /*
     * DELETE delete um comentátio 
     * 
     * @param id do comentário
     * 
     * @return  json 
     */ 
    public function destroy($id)
    {
        // usuário
        $user = Auth::guard('api')->user();
        $isAdmin = $user->checkRoles('admin');
        
        // delete
        $comment = Comment::findOrFail($id);
        // criador ou admin
        if($comment->user_id === $user->id || $isAdmin) {
            $comment->delete();
            return response()->json(['data' => 'success'], 201);
        }


    }
}
