<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Comment extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
        /// observer para salvar o historico de alterações
        Comment::observe(new \App\Observers\CommentHistoryObserver);
        /// UUID
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $fillable = [
        'body', 'user_id'
    ];
    //
    
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
    
    public function history() 
    {
        return $this->hasMany(CommentHistory::class)->with('user');
    }

}
