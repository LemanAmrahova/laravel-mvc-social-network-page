<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostController extends Controller
{

    public function create()
    {
        return view('Post.addpost');
    }

    public function edit($id)
    {

        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts.myposts')->with('error', 'Post not found.');
        }

        return view('Post.addpost', compact('post'));
    }

    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->user()->id;

        Post::create($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');;
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (!$post) {
            return redirect()->route('posts.myposts')->with('error', 'Post not found.');
        }

        if ($post->user_id == auth()->id()) {
            $validatedData = $request->validated();

            $post->title = $validatedData['title'];
            $post->content = $validatedData['content'];
            $post->publish_date = $validatedData['publish_date'];
            $post->save();

            return redirect()->route('posts.myposts')->with('success', 'Post updated successfully.');
        } else {
            return redirect()->route('posts.myposts')->with('error', 'Unauthorized action.');
        }
    }

    public function index()
    {
        $posts = Post::where('is_deleted', false)
            ->orderBy('publish_date', 'desc')
            ->get();

        return view('Post.posts', compact('posts'));
    }

//    public function postdetails(){
//        return view('Post.postdetails');
//    }

    public function myposts()
    {
        $posts = Post::where('is_deleted', false)
            ->where('user_id', auth()->id())
            ->orderBy('publish_date', 'desc')
            ->get();

        return view('Post.myposts', compact('posts'));
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return redirect()->route('posts.myposts')->with('error', 'Post not found.');
        }

        $post->update(['is_deleted' => true]);

        return redirect()->route('posts.myposts')->with('success', 'Post deleted successfully.');

    }

}
