<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Post;
use File;

class PostController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = array(
            'image'    => 'mimes:jpeg,jpg,png,gif|max:1024',
            'name'     => 'required|string|min:3|max:16',
            'title'    => 'required|string|min:10|max:32',
            'body'     => 'required|string|min:10|max:200',
            'password' => 'nullable|numeric|digits:4'
        );
    }

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('user/post/index', compact('posts'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (isset($request->image)) {
                $image = $request->file('image');
                $image->store('public/post');
            }

            Post::create([
                'name'     => $request->name,
                'title'    => $request->title,
                'body'     => $request->body,
                'password' => (isset($request->password)) ? bcrypt($request->password) : NULL,
                'image'    => (isset($request->image)) ? $image->hashName() : NULL
            ]);
            
            return redirect()->back();
        };
    }
    
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post->password != NULL) {
            if (Hash::check(session('password'), $post->password)) {
                $validator = Validator::make($request->all(), $this->rules);
                $image     = $request->file('image');
        
                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator);
                } else {
        
                    $post = Post::find($id);
                    $post->update([
                        'name'  => $request->name,
                        'title' => $request->title,
                        'body'  => $request->body
                    ]);
        
                    if (isset($request->delete_image) || isset($image)) {
                        Self::delete_image($post->image);
                        if (isset($image) && !isset($delete_image)) {
                            $image->store('public/post');
                        }
                        Post::find($post->id)->update([
                            'image' => (!empty($image) && !isset($request->delete_image)) ? $image->hashName() : NULL
                        ]);
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post->password != NULL) {
            if (Hash::check(session('password'), $post->password)) {
                Self::delete_image($post->image);
                Post::destroy($id);
            }
        }

        return redirect()->back();
    }

    public function delete_image($image)
    {
        $image_path = storage_path('app/public/post/' . $image);

        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }

    public function password_check(Request $request, $id)
    {
        $post   = Post::find($id);
        $action = (isset($request->edit)) ? 'edit' : 'delete';
        
        if (isset($post->password) && Hash::check($request->password, $post->password)) {
            session(['password' => $request->password]);
            return view('user/post/modal_fragments/' . $action, compact('post'));
        } else {
            if (!isset($post->password)) {
                $message = 'Can’t update/delete this post, because this post has not been set password.';
            } else {
                $message = 'The passwords you entered do not match. Please try again.';
            }

            return view('user/post/modal_fragments/error', compact('message', 'post', 'action'));
        }
    }
}