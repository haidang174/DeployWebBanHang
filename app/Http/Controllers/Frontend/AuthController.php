<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Login
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    // Register
    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đã đăng xuất!');
    }

    // ============================================================
    // GOOGLE LOGIN
    // ============================================================
    
    /**
     * Redirect người dùng đến Google để đăng nhập
     * 
     * LOCAL: Tắt SSL verification vì WAMP không có cacert.pem
     * PRODUCTION: Xóa phần setHttpClient() khi deploy lên server
     */
    public function redirectToGoogle()
    {
        $socialite = Socialite::driver('google');
        
        // CHỈ DÙNG CHO LOCAL DEVELOPMENT
        // KHI DEPLOY LÊN PRODUCTION: Xóa 3 dòng bên dưới
        if (config('app.env') === 'local') {
            $socialite->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
        }
        
        return $socialite->redirect();
    }

    /**
     * Xử lý callback từ Google sau khi user đăng nhập
     * 
     * LOCAL: Tắt SSL verification
     * PRODUCTION: Xóa phần setHttpClient() khi deploy
     */
    public function handleGoogleCallback()
    {
        try {
            $socialite = Socialite::driver('google');
            
            // CHỈ DÙNG CHO LOCAL DEVELOPMENT
            // KHI DEPLOY LÊN PRODUCTION: Xóa 3 dòng bên dưới
            if (config('app.env') === 'local') {
                $socialite->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }
            
            $googleUser = $socialite->user();

            // Tìm user theo email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // User đã tồn tại, cập nhật google_id nếu chưa có
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            } else {
                // Tạo user mới từ thông tin Google
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => null, // Google users không cần password
                ]);
            }

            // Đăng nhập user
            Auth::login($user);

            return redirect('/')->with('success', 'Đăng nhập Google thành công!');

        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Có lỗi xảy ra khi đăng nhập với Google. Vui lòng thử lại!');
        }
    }
}