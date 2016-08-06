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
    
    /*
     * web responce
     */
    
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
    
    public function blog ($nickname, $page = 1) {
        $user = User::where('nickname', $nickname)->first();
        
        if ($user == NULL) {
            abort(404);
        }
        
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
    
    public function readPost ($nickname, $id) {
        $post = Post::find($id);
        
        if ($post == NULL || $post->user->nickname != $nickname ) {
            abort(404);
        }
        
        $user =  $post->user;
        $owner = Auth::check() ? Auth::id() == $user->id : false;
        
        return view('read',[
            'me' => Auth::user(),
            'post' => $post,
            'owner' => $owner,
            'user' => $user
        ]);
    }
    
    public function editPost ($nickname, $id) {
        if (session("deleted-$id")) {
            return $this->safeRedirect();
        }
        
        $post = Auth::user()->getPost($id);
        
        if ($post == NULL || $post->user->nickname != $nickname ) {
            abort(404);
        }
        
        return view('edit',[
            'me' => Auth::user(),
            'post' => $post,
            'owner' => true,
            'user' => $post->user
        ]);
    }
    
    /*
     * editing
     */
    
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
        return redirect()->route('read-post', ['nickname'=> Auth::user()->nickname, 'id' => $id]);
    }
    
    public function privatePost ($id) {
        Auth::user()->privatePost($id);
        return redirect()->back();
    }
    
    public function deletePost ($id) {
        Auth::user()->deletePost($id);
        return redirect()->back()->with("deleted-$id", true);
    }
    
    public function safeRedirect() {
        if (Auth::check()) {
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        } else {
            return redirect(route('home'));
        }
    }
}
