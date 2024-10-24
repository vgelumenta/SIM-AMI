<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('last_seen', 'desc')->get();

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'nullable|min:8',
            'contact' => 'nullable|string|regex:/^[\d\s()+]+$/', // Memperbolehkan hanya angka, +, (, ), dan spasi
            'roles' => 'required',
        ]);

        $user = User::create($validatedData);

        $user->assignRole($request->roles);

        return redirect('/users')->with('status', 'Added user successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    public function editContact(User $user)
    {
        $user = Auth::user();

        return view('users.edit-contact', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateContact(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'contact' => [
                'required',
                'string',
                'unique:users',
                'regex:/^[\d\s()+]+$/', // Memperbolehkan hanya angka, +, (, ), dan spasi
            ],
        ]);

        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah pengguna memiliki kontak
        $user->update([
            'contact' => $request->input('contact'),
        ]);

        return redirect('/')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/users')->with('status', 'Delete successfully');
    }
}
