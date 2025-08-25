<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class Setting extends Controller
{
    public function edit(){
        $user = \Illuminate\Support\Facades\Auth::user(); // currently logged-in user
        return view('admin.settings',compact('user'));
    }



public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'phone'    => 'nullable|string|max:20',
        'old_password' => 'nullable|string',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user->name  = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // If new password provided
    if ($request->filled('password')) {
        // Require old password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('success', 'Settings updated successfully.');
}


}
