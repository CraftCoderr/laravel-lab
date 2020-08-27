<?php

namespace App\Http\Controllers;

use App\FullNameRule;
use App\Post;
use Faker\Provider\DateTime;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function admin()
    {
        return view('blog.admin');
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'image' => ['image', 'mimes:jpeg,jpg,png', 'max:10000'],
        ]);
        $data = $request->all();

        if ($request->has('image')) {
            $hash = md5((new \DateTime())->getTimestamp() . '-' . $data['title']);
            request()->image->move(public_path('images'), $hash);
        } else {
            $hash = null;
        }

        $post = Post::create([
            'title' => $data['title'],
            'text' => $data['text'],
            'image' => $hash,
        ]);
        $post->user()->associate(Auth::user());
        $post->save();
        return redirect('/');
    }

    public function delete($postId)
    {
        $post = Post::find($postId);
        if ($post && Auth::user()->can('delete article', $post)) {
            $post->delete();
        }
        return redirect('/');
    }

}
