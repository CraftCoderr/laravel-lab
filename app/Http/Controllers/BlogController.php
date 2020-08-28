<?php

namespace App\Http\Controllers;

use App\FullNameRule;
use App\Post;
use App\User;
use Core\Model\FormField;
use Core\Model\FormValidator;
use Core\Model\Rule\Required;
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

    public function publish(Request $request)
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

    public function import(Request $request)
    {
        $request->validate([
            'posts_data' => ['required', 'file', 'mimes:csv,txt', 'max:10000'],
        ]);

        $dataFile = $request->file('posts_data');

        if (($handle = fopen($dataFile->getRealPath(), "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000)) !== FALSE) {
                if (count($row) == 4) {
                    $data = [
                        'title' => $row[0],
                        'text' => $row[1],
                        'author' => User::where('name', $row[2])->first(),
                        'created_at' => $row[3]
                    ];

                    $validator = Validator::make($data, [
                        'title' => ['required', 'string', 'max:255'],
                        'text' => ['required', 'string'],
                        'author' => ['required'],
                        'created_at' => ['required', 'before:' . date('Y-m-d H:i:s')]
                    ]);
                    if ($validator->validate()) {
                        $user = $data['author'];
                        unset($data['author']);
                        $post = Post::create(
                            $data
                        );
                        $post->user()->associate($user);
                        $post->save();
                    }
                }
            }
            fclose($handle);
        }
        return redirect('/');
    }

}
