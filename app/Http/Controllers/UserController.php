<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $this->userService->updateProfile($request->all(), $request->file('avatar'));

        return redirect()->back()->with('status', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $this->userService->updatePassword($request->all());

        return redirect()->back()->with('status', 'Password updated successfully.');
    }

    public function comments()
    {
        $comments = auth()->user()->comments;

        return view('my.comment',compact('comments'));
    }

    public function ratings()
    {
        $comments = auth()->user()->comments;

        return view('my.rating',compact('comments'));
    }
}

