<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Routing\Controller;

class LikeController extends Controller
{
    public function store(Post $post)
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
