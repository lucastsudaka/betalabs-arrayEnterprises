<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; // passport
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    public static function boot()
    {
        parent::boot();
        /// UUID
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    
    
    public function getPhotoAttribute()
    {
        return 'storage/app/user_profile'.'/'.$this->attributes['photo'];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    

    

    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }    
    
    /*
     * 
     * -- Lógica para as roles
     * 
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    /*
     * Verifica as roles de usuário
     * 
     * @param: string | array  ver tabela "roles" do DB. 
     * 
     * @return boolean
     * 
     */
    public function checkRoles($roles)
    {
        // vamos buscar a role do usuário.
        $findRole = 0;
        if (is_array($roles)) 
        {
            $findRole = $this->roles()->whereIn('name', $roles)->count();      
        } 
        else 
        {
            $findRole = $this->roles()->where('name', $roles)->count();
        }     
        // caso o usuário pertença a uma role 
        if($findRole > 0) {
            return true;
        }
        return false;
             
    }




    
}
