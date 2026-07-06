<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Artiste;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    use HasApiTokens;
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Identifiants invalides'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    public function registerArtiste(Request $request)
    {

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nom_d_artiste' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
            'photo' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'a_la_une' => 'required|boolean',
            'Est_Artiste_Art3f' => 'required|boolean',
            'CV' => 'nullable|string|max:255',
            'localisations_id' => 'nullable|exists:localisations,id',
        ]);



        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'artiste',
        ]);

        Artiste::create([
            'user_id' => $user->id,
            'nom_d_artiste' => $validated['nom_d_artiste'],
            'bio' => $validated['bio'],
            'photo' => $validated['photo'],
            'iban' => $validated['iban'],
            'a_la_une' => $validated['a_la_une'],
            'Est_Artiste_Art3f' => $validated['Est_Artiste_Art3f'],
            'CV' => $validated['CV'],
            'localisations_id' => $validated['localisations_id'],
        ]);

        $token = $user->createToken('api')->plainTextToken;
        return new UserResource(
            $user,
        )->additional([
            'token' => $token,
        ]);
    }

    public function registerAcheteur(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'localisations_id' => 'nullable|exists:localisations,id',
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'acheteur',
        ]);
        Client::create([
            'user_id' => $user->id,
            'localisations_id' => $validated['localisations_id'],
        ]);
        $token = $user->createToken('api')->plainTextToken;
        return new UserResource(
            $user,
        )->additional([
            'token' => $token,
        ]);
    }
}
