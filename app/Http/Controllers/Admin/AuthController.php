<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use Illuminate\Http\Request;

use Auth;

class AuthController extends Controller
{
    public function login(AdminLogin $request)
    {
        if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
            return redirect(route('admin.index'));
        }

        return redirect()->back()->with(['error' => 'These credentials do not match our records.']);
    }

    public function loginPage()
    {
        return view('admin.auth.login');
    }
}
