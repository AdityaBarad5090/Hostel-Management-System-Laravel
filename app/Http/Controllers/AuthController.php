<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()  
    {
        return redirect('/');
    }

    public function login(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $request->password == $admin->password) {
            Session::put('admin', $admin->id);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid Email or Password');
    }

    public function logout()
    {
        Session::forget('admin');
        return redirect('/');
    }
}

