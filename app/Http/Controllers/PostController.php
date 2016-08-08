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
use App\Theme;
use Request;

class PostController extends BaseController
{
    //use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    /*
     * web responce
     */
    
    public function index () 
    {
        $posts = Post::whereIn('id', function($query){
            $query->selectRaw('max(id)')
            ->from('posts')
            ->groupBy('user_id');
        })->latest()
        ->take(10)
        ->get();
        
        return view('index',[
            /*layout*/
            'me' => Auth::user(),
            'themes' => Theme::all(),
            //'owner' => false, //if you own content on this page
            'main' => true, //if it's main page
            //'myBlog' => false, //if it's your blog page
            /* index */
            'posts' => $posts, //last posts from 10 different users
        ]);
    }
    
    public function blog ($nickname, $page = 1) 
    {
        $user = User::where('nickname', $nickname)->first();
        
        if ($user == NULL) {
            abort(404);
        }
        
        //check if it's your own blog
        $owner = Auth::check() ? Auth::id() == $user->id : false;
        //set page for paginator
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        //retrive posts for this page
        $posts = $user->posts($owner)->paginate(5);
        
        return view('index',[
            /*layout*/
            'me' => Auth::user(),
            'themes' => Theme::all(),
            'owner' => $owner, //if you own content on this page
            'myBlog' => $owner, //if it's your blog page
            'user' => $user, //user who own content on this page
            /* index */
            'posts' => $posts, 
            'page' => $page
        ]);
    }
    
    public function readPost ($id) 
    {
        //after deleting post from read page, 
        //we can accidently be redirected here again
        if (session("deleted-$id")) {
            return $this->safeRedirect();
        }
        
        $post = Post::find($id);
        
        //if post not found
        if ($post == NULL) {
            abort(404);
        }
        
        $user = $post->user;
        //check if it's your post
        $owner = Auth::check() ? Auth::id() == $user->id : false;
        
        //if it's private
        if ($post->private && !$owner) {
            abort(403);
        }
        
        return view('read',[
            'me' => Auth::user(),
            'themes' => Theme::all(),
            'post' => $post,
            'owner' => $owner, //if you own content on this page
            'user' => $user //user who own content on this page
        ]);
    }
    
    public function editPost ($id) 
    {
        //after deleting post from edit page, 
        //we can accidently be redirected here again
        if (session("deleted-$id")) {
            return $this->safeRedirect();
        }
        
        $post = Auth::user()->getPost($id);
        
        //if post not found or it's not yours
        if ($post == NULL) {
            abort(404);
        }
        
        return view('edit',[
            'me' => Auth::user(),
            'themes' => Theme::all(),
            'post' => $post,
            'owner' => true, //if you own content on this page
            'user' => Auth::user() //user who own content on this page
        ]);
    }
    
    /*
     * editing
     */
    
    public function createPost () 
    {
        Auth::user()->createPost([
            'text' => Request::input('text')
        ]);
        
        return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
    }
    
    public function updatePost ($id) 
    {   
        Auth::user()->updatePost($id, [
            'title' => Request::input('title'),
            'text' => Request::input('text')
        ]);
        return redirect()->route('read-post', ['id' => $id]);
    }
    
    public function privatePost ($id) 
    {
        Auth::user()->privatePost($id);
        return redirect()->back();
    }
    
    public function deletePost ($id) 
    {
        Auth::user()->deletePost($id);
        return redirect()->back()->with("deleted-$id", true);
    }
    
    public function safeRedirect() 
    {
        if (Auth::check()) {
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        } else {
            return redirect(route('home'));
        }
    }
}
