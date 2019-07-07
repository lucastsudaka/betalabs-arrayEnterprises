<?php

namespace App\Observers;
use Illuminate\Support\Facades\Auth;
use App\CommentHistory;
use App\Comment;

class CommentHistoryObserver
{
    /* 
     * Salvamos o estado atual (antes de atualizar) 
     */
    public function updated(Comment $comment )  {
        
        
        if (Auth::guard('api')->user()) {
            $comment = $comment->getOriginal(); // pegando o valor original (antes da alteração)
            CommentHistory::create([
                'user_id'      => $comment['user_id'],
                'comment_id'       => $comment['id'],
                'body' => $comment['body'],
                'updated_at' => $comment['updated_at'],
                'created_at' => $comment['created_at']
            ]);
        }
       
    }    

}


