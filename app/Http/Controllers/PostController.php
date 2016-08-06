<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Pagination\Paginator;
use Auth;
use App\User;
use App\Post;
use Request;

class PostController extends BaseController
{
    //use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public function index () {
        $posts = Post::orderBy('created_at', 'desc')
            ->where('private', false)
            ->groupby('user_id')
            ->limit(2)
            ->get();
        
        return view('index',[
            'user' => NULL,
            'owner' => false,
            'me' => Auth::user(),
            'posts' => $posts,
            'main' => true
        ]);
    }
    
    public function readPost ($id) {
        $post = Post::find($id);
        $user =  $post->user;
        $owner = Auth::check() ? Auth::id() == $user->id : false;
        $view = $owner ? 'edit' : 'read';
        return view($view,[
            'me' => Auth::user(),
            'post' => $post,
            'owner' => $owner,
            'user' => $user
        ]);
    }
    
    public function blog ($nickname, $page = 1) {
        $user = User::where('nickname', $nickname)->first();
        $owner = Auth::check() ? Auth::id() == $user->id : false;
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $posts = $user->posts($owner)->paginate(5);
        
        return view('index',[
            'me' => Auth::user(),
            'user' => $user,
            'owner' => $owner,
            'posts' => $posts,
            'page' => $page
        ]);
    }
    
    
    public function createPost () {
        Auth::user()->createPost([
            'text' => Request::input('text')
        ]);
        
        return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
    }
    
    public function updatePost ($id) {
        
        Auth::user()->updatePost($id, [
            'title' => Request::input('title'),
            'text' => Request::input('text')
        ]);
        //return to read post
        return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
    }
    
    public function privatePost ($id) {
        Auth::user()->privatePost($id);
        return redirect()->back();
    }
    
    public function deletePost ($id) {
        Auth::user()->deletePost($id);
        return redirect()->back();
    }
}
