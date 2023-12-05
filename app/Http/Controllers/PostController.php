<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showCreateForm()
    {

        return view('create-post');
    }

    public function storeNewPost(Request $request)
    {

        $incomingFields = $request->validate([
            'title' => ['string', 'required', 'max:255'],
            'body' => ['string', 'required']
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']); //sanitizing input by stripping HTML and PHP tags from a string
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New Post Created!');

    }

    public function viewSinglePost(Post $post)
    {

        return view('single-post', ['post' => $post]);
    }

    public function delete(Post $post)
    {
        if (auth()->user()->cannot('delete', $post)) {
            return "you can't do that!";
        }
        $post->delete();

        return redirect('profile/' . auth()->user()->username)->with('success', 'Post Deleted!');
    }


}
