<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewPostEmail;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        dispatch(new SendNewPostEmail(['sendTo' => auth()->user()->email, 'name' => auth()->user()->username, 'title' => $newPost->title]));

        return redirect("/post/{$newPost->id}")->with('success', 'New Post Created!');

    }

    public function viewSinglePost(Post $post)
    {
        $post['body'] = strip_tags(Str::markdown($post->body));
        return view('single-post', ['post' => $post]);
    }

    public function showEditForm(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }

    public function actuallyUpdate(Post $post, Request $request)
    {

        $incomingFields = $request->validate([
            'title' => ['string', 'required'],
            'body' => ['string,required[']
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']); //sanitizing input by stripping HTML and PHP tags from a string
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'post updated');

    }

    public function delete(Post $post)
    {
        if (auth()->user()->cannot('delete', $post)) {
            return "you can't do that!";
        }
        $post->delete();

        return redirect('profile/' . auth()->user()->username)->with('success', 'Post Deleted!');
    }

    public function search($term)
    {
        $posts = POST::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
        //return Post::where('title', 'LIKE', '%' . $term . '%')->orWHere('body', 'LIKE', '%' . $term . '%');

    }

    //API

    public function storeNewPostApi(Request $request)
    {

        $incomingFields = $request->validate([
            'title' => ['string', 'required', 'max:255'],
            'body' => ['string', 'required']
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']); //sanitizing input by stripping HTML and PHP tags from a string
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return $newPost->id;

    }

    //API

    public function deleteApi(Post $post)
    {
        if (auth()->user()->cannot('delete', $post)) {
            return "you can't do that!";
        }
        $post->delete();

        return 'True';
    }


}
