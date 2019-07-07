<?php

use Illuminate\Database\Seeder;
use App\Comment;
use App\CommentHistory;
use App\User;
use App\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                

        
        factory(User::class, 3)->create()->each(function($user) {
            $roleUser  = Role::where('name', 'basic')->first();
            $user->roles()->attach($roleUser);
            factory(Comment::class, 3)->create(['user_id'=>$user->id])->each(function($comment) {
                factory(CommentHistory::class, 5)->create(['user_id'=>$comment->user_id, 'comment_id'=>$comment->id]);
            });          
        });
      
    }
}
