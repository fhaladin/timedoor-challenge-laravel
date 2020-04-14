<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Http\Requests\PostValidation;
use App\Models\Post;
use File;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('user/post/index', compact('posts'));
    }
    
    public function store(PostValidation $request)
    {
        if (isset($request->image)) {
            $image = $request->file('image');
            $image->store('public/post');
        }

        Post::create([
            'user_id'  => (Auth::user()) ? Auth::user()->id : null,
            'name'     => $request->name,
            'title'    => $request->title,
            'body'     => $request->body,
            'password' => (isset($request->password)) ? bcrypt($request->password) : NULL,
            'image'    => (isset($request->image)) ? $image->hashName() : NULL
        ]);
        
        return redirect()->back();
    }
    
    public function update(PostValidation $request, $id)
    {
        $post = Post::find($id);

        if (Hash::check(session('password'), $post->password) || (Auth::check() && Auth::user()->id === $post->user_id)) {
            $image = $request->file('image');
            $post  = Post::find($id);
            
            $post->update([
                'name'  => $request->name,
                'title' => $request->title,
                'body'  => $request->body
            ]);

            if (isset($request->delete_image) || isset($image)) {
                Self::delete_image($id);
                if (isset($image) && !isset($delete_image)) {
                    $image->store('public/post');
                }
                Post::find($post->id)->update([
                    'image' => (!empty($image) && !isset($request->delete_image)) ? $image->hashName() : NULL
                ]);
            }
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (Hash::check(session('password'), $post->password) || (Auth::check() && Auth::user()->id === $post->user_id) || Auth::guard('admin')->check()) {
            Post::destroy(explode(',', $id));
        }

        return redirect()->back();
    }

    public function delete_image($id, $redirect = false)
    {
        $post       = Post::find($id);
        $image_path = storage_path('app/public/post/' . $post->image);

        if(File::exists($image_path)) {
            File::delete($image_path);
            $post->update(['image' => NULL]);
        }

        if ($redirect) {
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        Post::onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    public function password_check(Request $request, $id)
    {
        $post   = Post::find($id);
        $action = (isset($request->edit)) ? 'edit' : 'delete';

        if ((Hash::check($request->password, $post->password)) || (Auth::check() && Auth::user()->id === $post->user_id)) {
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