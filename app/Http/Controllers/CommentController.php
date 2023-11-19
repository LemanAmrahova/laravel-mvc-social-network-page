<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    public function index($id)
    {
        $post = Post::with(['comments' => function ($query) {
            $query->where('is_deleted', false);
        }])->find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found.');
        }

        return view('Post.postdetails', compact('post'));
    }

    public function store(StoreCommentRequest $request, $id)
    {
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->post_id = $id;
        $comment->content = $request->validated('content');
        $comment->save();

        $post = Post::with('comments')->find($id);

        return redirect()->route('posts.details', compact('post'))->with('success', 'Comment added successfully.');
    }

    public function destroy($id)
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
