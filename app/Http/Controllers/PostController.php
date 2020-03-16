<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Post;
use File;

class PostController extends Controller
{
    private $rules;

    public function __construct(){
        $this->rules = array(
            'image'     => 'mimes:jpeg,jpg,png,gif|max:1024',
            'name'      => 'required|string|min:3|max:16',
            'title'     => 'required|string|min:10|max:32',
            'body'      => 'required|string|min:10|max:200'
        );
    }

    public function index(){
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('index', compact('posts'));
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $post = Post::create([
                'name'      => $request->name,
                'title'     => $request->title,
                'body'      => $request->body,
                'password'  => bcrypt($request->password)
            ]);
            
            if (isset($request->image)) {
                $image = $request->file('image');
                $image->store('public');
               
                Post::find($post->id)->update([
                    'image' => $image->hashName()
                ]);
            }
                    
            return redirect()->back();
        };
    }
    
    public function update(Request $request){
        $validator = Validator::make($request->all(), $this->rules);
        $delete_image = $request->delete_image;
        $image = $request->file('image');

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator);
        } else {
            $post = Post::find(Auth::guard('post')->user()->id);
            $post->update([
                'name'      => $request->name,
                'title'     => $request->title,
                'body'      => $request->body
            ]);

            if (isset($delete_image) || isset($image)) {
                Self::delete_image($post->image);
                if (isset($image) && !isset($delete_image)) {
                    $image->store('public');
                }
            }

            Post::find($post->id)->update([
                'image' => (!empty($image) && !isset($delete_image)) ? $image->hashName() : null
            ]);

            return redirect()->back();
        }
    }

    public function destroy(){
        $id = Auth::guard('post')->user()->id;
        $post = Post::find($id);

        Self::delete_image($post->image);
        Post::destroy($id);

        return redirect()->back();
    }

    public function delete_image($image){
        $image_path = storage_path('app/public/' . $image);

        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }

    public function password_check(Request $request){
        session(['id' => $request->id ?? session('id')]);
        $post = Post::find(session('id'));

        if (Auth::guard('post')->attempt(['id' => session('id'), 'password' => $request->password])) {
            $response          = Auth::guard('post')->user();
            $response['edit']  = ($request->edit) ? TRUE : FALSE ;
            $response['image'] = (!empty($post->image)) ? asset('storage/' . $post->image) : 'http://via.placeholder.com/500x500' ;
        } else {
            $response['error'] = TRUE;
        }

        return response()->json($response);
    }
}