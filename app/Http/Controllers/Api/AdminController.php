<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        $token = $user->createToken('api')->plainTextToken;
        return new UserResource(
            $user,
        )->additional([
            'token' => $token,
        ]);
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $nomUser = $user->nom . ' ' . $user->prenom;
        $user->delete();

        return response()->json(['message' => "Utilisateur $nomUser n'existe plus désormais"]);
    }

    public function getAllUsers()
    {
        $user = User::all();
        return UserResource::collection($user);
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    public function statsArt3fShop()
    {
        $totalUsers = User::count();
        $totalArtistes = User::where('role', 'artiste')->count();
        $totalAcheteurs = User::where('role', 'acheteur')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_artistes' => $totalArtistes,
            'total_acheteurs' => $totalAcheteurs,
            'total_admins' => $totalAdmins,
        ]);
    }
}
