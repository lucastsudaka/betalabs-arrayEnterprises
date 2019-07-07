<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * Principal objetivo é dar suporte ao observer "CommentHistory"
 * 
 */
class CommentHistory extends Model
{
    protected $fillable = [
        'body', 'comment_id','user_id', 'created_at', 'updated_at'
    ];
    protected $table = 'comments_history';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
