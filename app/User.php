<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $primaryKey = 'id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'nickname'
    ];
    
    
    protected $casts = [ 'id' => 'string' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id')->orderBy('created_at', 'desc');
    }
    
    public function deletePost($id)
    {
        $post = Post::find($id); 
        if ($post != NULL) {
            $post->delete();
        }
    }
}
