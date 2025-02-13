<?php

namespace App\Http\Controllers;

use App\Models\Form;
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

    public function index(Form $form)
    {
        $stages = Stage::all();

        $users = User::where('last_seen', '>=', now()->subMinutes(3))
            ->orderBy('last_seen', 'desc')
            ->get();

        // $forms = Form::with('formTime')->where('document_id', 2)->get();

        $forms = Form::with([
            'formAudits.indicator.competency.standard.category',
            'formTime'
        ])->where('document_id', 2)->get();

        $categoriesStats = [];

        foreach ($forms as $form) {
            // Grupkan formAudits berdasarkan kategori
            $grouped = $form->formAudits->groupBy('indicator.competency.standard.category.id');

            foreach ($grouped as $categoryId => $category) {
                if (!isset($categoriesStats[$categoryId])) {
                    $categoriesStats[$categoryId] = [
                        'total_standards' => 0,
                        'passed_standards' => 0,
                    ];
                }

                foreach ($category->groupBy('indicator.competency.standard.id') as $standardId => $standard) {
                    $categoriesStats[$categoryId]['total_standards']++;

                    $allCompetenciesPassed = true;
                    foreach ($standard->groupBy('indicator.competency.id') as $competencyId => $indicators) {
                        $competencyPassed = $indicators->every(fn($indicator) => $indicator->validation_status >= 3);
                        if (!$competencyPassed) {
                            $allCompetenciesPassed = false;
                            break;
                        }
                    }

                    if ($allCompetenciesPassed) {
                        $categoriesStats[$categoryId]['passed_standards']++;
                    }
                }
            }
        }

        // Hitung persentase lulus untuk setiap kategori
        $categoryPercentages = [];

        foreach ($categoriesStats as $categoryId => $stats) {
            $total = $stats['total_standards'];
            $passed = $stats['passed_standards'];
            $categoryPercentages[$categoryId] = $total > 0 ? round(($passed / $total) * 100, 2) : 0;
        }

        // Debugging
        // dd($categoryPercentages);

        // Hitung rata-rata persentase kategori dari semua form
        // $averageCategoryPercentage = $totalForms > 0 ? $totalCategoryPercentage / $totalForms : 0;

        // Hitung jumlah tepat waktu dan tidak tepat waktu
        [$tepatWaktu, $tidakTepatWaktu] = $forms->partition(function ($form) {
            return optional($form->formTime)->submission_time <= optional($form->formTime)->submission_deadline;
        })->map->count();

        // Kirim data ke view
        return view('dashboard', compact('stages', 'users', 'tepatWaktu', 'tidakTepatWaktu', 'categoryPercentages'));
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
