<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use App\Models\Post;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use File;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function table(Request $request, $search = FALSE)
    {
        $posts = ($search) ? Self::search($request) : Post::withTrashed()->get();
        return Datatables::of($posts)->rawColumns(['checkbox', 'image_html', 'date', 'action'])
                        ->addColumn('checkbox', 'admin.dashboard.table_fragments.checkbox')
                        ->addColumn('image_html', 'admin.dashboard.table_fragments.image')
                        ->addColumn('date', 'admin.dashboard.table_fragments.date')
                        ->addColumn('action', 'admin.dashboard.table_fragments.action')
                        ->make(true);
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);
     
        Self::delete_image($ids);
        Post::destroy($ids);
    }

    public function restore($id)
    {
        Post::onlyTrashed()->find($id)->restore();
    }

    public function delete_image($ids)
    {
        $ids = (is_array($ids)) ? $ids : explode(',', $ids);
        
        foreach ($ids as $id) {
            $post       = Post::find($id);
            $image_path = storage_path('app/public/post/' . $post->image);
    
            if(File::exists($image_path)) {
                File::delete($image_path);
                $post->update(['image' => NULL]);
            }
        }
    }

    public function modal(Request $request)
    {
        $type = $request->type;
        $id   = $request->id ?? NULL;
        
        return view('admin.dashboard.modal_fragments.' . $type, compact('id'));
    }

    public function search($request)
    {
        $posts = Post::where('title', 'like', "%".$request->title."%")->where('body', 'like', "%".$request->body."%");

        if ($request->image === 'with') {
            $posts = $posts->whereNotNull('image');
        } elseif ($request->image === 'without') {
            $posts = $posts->whereNull('image');
        }

        if (!isset($request->status)) {
            $posts = $posts->withTrashed();
        } elseif ($request->status === 'delete') {
            $posts = $posts->onlyTrashed();
        }

        return $posts->get();
    }
}
