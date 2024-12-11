<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        // Determine whether login uses email or username
        $userField = filter_var($request->input('user'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credential = [
            $userField => $request->input('user'),
            'password' => $request->input('password')
        ];

        $user = User::where('email', $request->input('user'))
            ->orWhere('username', $request->input('user'))
            ->first();

        if ($user) {

            $response = Http::post('https://api-gerbang.itk.ac.id/api/siakad/login', $credential);

            if ($response->successful()) {
                // Login pengguna jika memiliki role
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('/');
            } else if (Auth::attempt($credential)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            } else {
                return back()->withErrors(['Error' => 'Login gagal, coba lagi']);
            }

        } else {
            
            return back()->withErrors(['Error' => 'Pengguna belum terdaftar.']);

        }
    }

    public function index()
    {
        $stages = Stage::all();
        return view('dashboard', compact('stages'));
    }

    public function updateStage(Request $request, Stage $stage)
    {
        // Validasi input
        $validated = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        Stage::updateOrCreate(
            ['id' => $stage->id], // Kondisi untuk mencari form
            [
                'description' => $validated['description'],
            ]
        );

        // Redirect setelah semua perubahan tersimpan
        return redirect('/')->with('status', 'Stage berhasil diperbarui.');
    }

    public function logout(Request $request)
    {
        Cache::forget('user_role_' . Auth::id());

        Cache::forget('user-' . Auth::id() . '-is-online');

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
