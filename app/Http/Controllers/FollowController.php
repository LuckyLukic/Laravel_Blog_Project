<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller {
    public function createFollow(User $user) {

        if($user->id == auth()->user()->id) {
            return back()->with('failure', ' you can\'t follow yourself!');
        }

        $existCheck = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();

        if($existCheck) {
            return back()->with('failure', 'you are already following that user');
        }

        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();
    }

    public function removeFollow() {


    }


}
