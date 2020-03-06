<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use Validator;
use File;

class PostController extends Controller
{
    private $rules;

    public function __construct(){
        $this->rules = array(
            'image'     => 'mimes:jpeg,jpg,png,gif|max:1024',
            'name'      => 'required|string|min:3|max:16',
            'title'     => 'required|string|min:10|max:32',
            'body'      => 'required|string|min:10|max:200',
            'password'  => 'required|string'
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
                'password'  => $request->password
            ]);
            
            if (isset($request->image)) {
                $file = $request->file('image');
                Post::find($post->id)->update([
                    'image' => $post->id . '.' . $file->getClientOriginalExtension()
                ]);

                $file->move('image', $post->id .  '.' . $file->getClientOriginalExtension());
            }
                    
            return redirect()->back();
        };
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $post = Post::find($id);
            $post->update([
                'name'      => $request->name,
                'title'     => $request->title,
                'body'      => $request->body,
                'password'  => $request->password
            ]);

            if (isset($request->delete_image)) {
                Self::delete_image($post->image);
            } else {
                if (isset($request->image)) {
                    $file = $request->file('image');
                    Self::delete_image($post->image);
                    Post::find($post->id)->update([
                        'image' => $post->id . '.' . $file->getClientOriginalExtension()
                    ]);
    
                    $file->move('image', $post->id .  '.' . $file->getClientOriginalExtension());
                }
            }

            return redirect()->back();
        }
    }

    public function destroy($id){
        $post = Post::find($id);

        Self::delete_image($post->image);
        Post::destroy($id);

        return redirect()->back();
    }

    public function delete_image($image){
        $image_path = public_path('image/' . $image);

        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }

    public function password_check(Request $request){
        $post = Post::find($request->id);
        
        if ($request->password === $post->password) {
            $response = $post;
            if ($request->edit) {
                $response['edit'] = $request->edit;
                $response['edit_url'] = route('post.update', $post->id);
                $response['edit_image'] = asset('image/' . $post->image);
            } else {
                $response['delete_url'] = route('post.destroy', $post->id);
            }
        } else {
            $response['error'] = TRUE;
        }
        
        return response()->json($response);
    }

}