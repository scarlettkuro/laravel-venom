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
    
    public function posts($owner)
    {
        $query = $this->hasMany(Post::class, 'user_id')->orderBy('created_at', 'desc');
        if ($owner) {
            return $query;
        } else {
            return $query->where('private', false);
        }
    }
    
    public function getPost($id)
    {
        return Post::where('id', $id)->where('user_id', $this->id)->first();
    }
    
    public function createPost($fields)
    {
        $post = new Post($fields);
        $post->user_id = $this->id;
        $post->save();
    }
    
    public function updatePost($id, $fields)
    {
        $post = $this->getPost($id);
        
        if ($post != NULL) {
            $post->update($fields); //save?
            //post belong to this user and work is done
            return true;
        }
        //post don't belong to this user
        return false;
    }
    
    public function privatePost($id)
    {
        $post = $this->getPost($id);
        
        if ($post != NULL) {
            $post->private = ! $post->private;
            $post->save();
            //post belong to this user and work is done
            return true;
        }
        //post don't belong to this user
        return false;
    }
    
    public function deletePost($id)
    {
        $post = $this->getPost($id);
        
        if ($post != NULL) {
            $post->delete();
            //post belong to this user and work is done
            return true;
        }
        //post don't belong to this user
        return false;
    }
}
