<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //$posts = Post::get();
        $posts = Post::orderBy('created_at', 'desc')->with('user', 'likes')->paginate(20);
        return view('posts.index' , ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

/*        Post::create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);*/

        //auth()->user()->posts()->create();
        //dd(auth()->user()->posts);
/*        $request->user()->posts()->create([
            'body' => $request->body
        ]);*/
        $request->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post )
    {
/*        if(!$post->ownedBy(auth()->user()))
        {
            dd('no');
        }*/
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }
}
