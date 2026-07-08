<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users',compact($users));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.show', compact($user));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $admin = $request->validate([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        User::firstOrCreate([
            'nom' => $admin['nom'],
            'prenom' => $admin['prenom'],
            'email' => $admin['email'],
            'password' => Hash::make($admin['password']),
            'role' => 'admin',
        ]);

        return back()->with('success', 'Nouvel admin créé');
    }
}
