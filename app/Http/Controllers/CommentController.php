<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Post;
use  App\Models\Comment;

class CommentController extends Controller
{

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
}
