<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Post;
use  App\Models\Comment;

class PostController extends Controller
{

    public function addpostGet()
    {
            return view('addpost');
    }

    public function edit($id){

        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('myposts')->with('error', 'Post not found.');
        }

        return view('addpost', compact('post'));
    }

    public function addpost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:20|max:1000',
            'publish_date' => 'required|date',
        ]);


        $post = new Post();
        $post->id = $request->input('id');
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->publish_date = $validatedData['publish_date'];
        $post->user_id = $request->input('user_id');
        $post->save();

        return redirect()->route('posts');
    }

    public function editpost(Request $request, $id){

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:20|max:1000',
            'publish_date' => 'required|date',
        ]);

        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('myposts')->with('error', 'Post not found.');
        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->publish_date = $request->input('publish_date');
        $post->save();

        return redirect()->route('myposts')->with('success', 'Post updated successfully.');

    }

    public function posts()
    {
        $posts = Post::where('is_deleted', false)
        ->orderBy('publish_date', 'desc')
        ->get();

        return view('posts', compact('posts'));
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        if ($user->likes->contains('id', $post->id)) {
            $user->likes()->updateExistingPivot($post->id, ['is_deleted' => true]);
            $user->likes()->detach($post);
        } else {
            $user->likes()->attach($post->id, ['is_deleted' => false]);
        }

        return redirect()->back();
    }

    public function postdetails(){
        return view('postdetails');
    }

    public function comments($id)
    {
        $post = Post::with(['comments' => function ($query) {
            $query->where('is_deleted', false);
        }])->find($id);

        if (!$post) {
            return redirect()->route('posts')->with('error', 'Post not found.');
        }

        return view('postdetails', compact('post'));
    }

    public function addcomments(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);
    
        $comment = new Comment();
        $comment->user_id = auth()->id(); 
        $comment->post_id = $id;
        $comment->content = $request->input('content');
        $comment->save();

        $post = Post::with('comments')->find($id);

        return redirect()->route('postdetails', compact('post'))->with('success', 'Comment added successfully.');
    }

    public function deletecomment($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }
    
        if (auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'You do not have permission to delete this comment.');
        }
    
        $comment->is_deleted = true;
        $comment->save();
    
        return redirect()->back()->with('success', 'Comment soft-deleted successfully.');
    
    }

    public function myposts()
    {
        $posts = Post::where('is_deleted', false)
        ->where('user_id', auth()->id())
        ->orderBy('publish_date', 'desc')
        ->get();

        return view('myposts', compact('posts'));
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('myposts')->with('error', 'Post not found.');
        }
    
        $post->update(['is_deleted' => true]);
    
        return redirect()->route('myposts')->with('success', 'Post deleted successfully.');
    
    }

}
