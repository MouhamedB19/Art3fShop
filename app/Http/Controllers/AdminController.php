<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Oeuvre;
use App\Models\Tirage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_clients'  => User::where('role', 'acheteur')->count(),
            'total_artistes' => User::where('role', 'artiste')->count(),
            'total_oeuvres'  => Oeuvre::count(),
            'total_tirages'  => Tirage::count(),
            'tirages_vendus' => Tirage::where('status', 'vendu')->count(),
        ];
        return view('admin.index', compact('stats'));
    }

    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $admin = $request->validate([
            'nom'      => 'required|string|max:255',
            'prenom'   => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::firstOrCreate([
            'nom' => $admin['nom'],
            'prenom' => $admin['prenom'],
            'email' => $admin['email'],
            'password' => Hash::make($admin['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Nouvel admin créé');
    }
}
