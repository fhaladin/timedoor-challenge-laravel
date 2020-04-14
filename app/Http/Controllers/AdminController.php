<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\AdminLogin;
use App\Models\Post;

use Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard.index');
        } else {
            return view('auth.admin_login');
        }
    }

    public function login(AdminLogin $request)
    {
        if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
            return redirect()->back();
        }

        return redirect()->back()->with(['error' => 'These credentials do not match our records.']);
    }

    public function table($search = FALSE)
    {
        if ($search) {
            $posts = Post::where('title', 'like', "%".$_POST['title']."%")
                            ->where('body', 'like', "%".$_POST['body']."%");

            if ($_POST['image'] === 'with') {
                $posts = $posts->whereNotNull('image');
            } elseif ($_POST['image'] === 'without') {
                $posts = $posts->whereNull('image');
            }

            if ($_POST['status'] === '') {
                $posts = $posts->withTrashed();
            } elseif ($_POST['status'] === 'delete') {
                $posts = $posts->onlyTrashed();
            }

            $posts = $posts->get();
        } else {
            $posts = Post::withTrashed()->get();
        }

        return Datatables::of($posts)
                        ->addIndexColumn()
                        ->addColumn('checkbox', function($post){
                            return view('admin.dashboard.table_fragments.checkbox', compact('post'))->render();
                        })
                        ->addColumn('image', function($post){
                            return view('admin.dashboard.table_fragments.image', compact('post'))->render();
                        })
                        ->addColumn('date', function($post){
                            $created_at = strtotime($post->created_at);
                            return view('admin.dashboard.table_fragments.date', compact('created_at'))->render();
                        })
                        ->addColumn('action', function($post){
                            return view('admin.dashboard.table_fragments.action', compact('post'))->render();
                        })
                        ->rawColumns(['checkbox', 'image', 'date', 'action'])
                        ->make(true);
    }

    public function modal()
    {
        $type = $_POST['type'];
        $id   = $_POST['id'] ?? NULL;
        
        return view('admin.dashboard.modal_fragments.' . $type, compact('id'));
    }
}