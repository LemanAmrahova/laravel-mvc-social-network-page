<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Post;
use  App\Models\Comment;

class LikeController extends Controller
{
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

}
