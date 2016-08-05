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
        return view('index',[
            'user' => NULL,
            'owner' => false,
            'me' => Auth::user(),
            'posts' => Post::orderBy('created_at', 'desc')->limit(2)->groupby('user_id')->get(),
            'main' => true
        ]);
    }
    
    public function post () {
        if (Auth::check()) {
            $post = new Post();
            $post->text = Request::input('text');
            $post->user_id = Auth::id();
            $post->save();
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        }
        return redirect(route('home'));
    }
    
    public function blog ($nickname, $page = 1) {
        $user = User::where('nickname', $nickname)->first();
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $posts = $user->posts()->paginate(5);
        //$posts->setCurrentPage($page);
        return view('index',[
            'me' => Auth::user(),
            'user' => $user,
            'owner' => Auth::check() ? Auth::user()->nickname == $nickname : false,
            'posts' => $posts,
            'page' => $page
        ]);
    }
    
    public function deletePost ($id) {
        if (Auth::check()) {
            Auth::user()->deletePost($id);
            return redirect(route('blog', ['nickname' => Auth::user()->nickname ]));
        }
        return redirect(route('home'));
    }
}
