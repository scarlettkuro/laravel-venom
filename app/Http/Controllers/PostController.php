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
    
    public function createPost () {
        if (Auth::check()) {
            $post = new Post();
            $post->text = Request::input('text');
            $post->user_id = Auth::id();
            $post->save();
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        }
        return redirect(route('home'));
    }
    
    public function updatePost ($id) {
        if (Auth::check()) {
            $post = Post::find($id);
            $post->text = Request::input('text');
            $post->title = Request::input('title');
            $post->save();
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        }
        return redirect(route('home'));
    }
    
    public function readPost ($id) {
        $post = Post::find($id);
        $user =  $post->user;
        return view('post',[
            'me' => Auth::user(),
            'post' => $post,
            'owner' => Auth::check() ? Auth::id() == $user->id : false,
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
        //$posts->setCurrentPage($page);
        return view('index',[
            'me' => Auth::user(),
            'user' => $user,
            'owner' => $owner,
            'posts' => $posts,
            'page' => $page
        ]);
    }
    
    public function privatePost ($id) {
        if (Auth::check()) {
            $post = Post::find($id);
            $post->private = ! $post->private;
            $post->save();
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        }
        return redirect(route('home'));
    }
    
    public function deletePost ($id) {
        if (Auth::check()) {
            Auth::user()->deletePost($id);
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        }
        return redirect(route('home'));
    }
}
