<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
   
    public function register(Request $request)
    {
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users',
        'phone'    => 'required|numeric',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the user
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    // Log in the user immediately
    Auth::login($user);

    // Send verification link to user email
    $user->sendEmailVerificationNotification();

    // Redirect to verify-email page
    return redirect()->route('verification.notice')
        ->with('success', 'Account created! Please check your email to verify your account.');
    }
     public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
                if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.home');
            } elseif (Auth::user()->role === 'user') {
                return redirect()->route('user.home');
            }
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        return back()->with('error', 'Invalid credentials. Please try again.');
    }
    public function showUserProfile()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.user-management', compact('users'));
    }
    
        // 👇 NEW — Show a single user (AJAX for modal)
public function showUser($id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}

// 👇 NEW — Delete user (AJAX)
public function deleteUser($id)
{
    User::findOrFail($id)->delete();
    return response()->json(['success' => true]);
}
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('auth')->with('success','Logged out.');
}


// public function verify(EmailVerificationRequest $request)
// {
//     if (Auth::user()->hasVerifiedEmail()) {
//         return redirect()->route('auth')->with('message', 'Email already verified.');
//     }

//     $request->fulfill();

//     return redirect()->route('auth')->with('message', 'Email verified successfully! Please log in.');
// }


}
