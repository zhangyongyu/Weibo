<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来！🤗');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '抱歉，您和邮箱和密码不匹配😢');
            return redirect()->back();
        }

        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出👋');
        return redirect('login');
    }
}
