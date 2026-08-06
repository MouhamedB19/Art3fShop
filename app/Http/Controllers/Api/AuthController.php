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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

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
                'message' => 'Identifiants invalides',
                'code' => 400
            ]);
        }

        $user = Auth::user();

        $token = $user->createToken('api')->plainTextToken;

        return (new UserResource($user))->additional(['token' => $token]);
    }

    public function index()
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    
    public function register(Request $request)
    {
        
        $dataUser = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:artiste,acheteur'],
        ]);

        
        $user = User::create([
            'nom' => $dataUser['nom'],
            'prenom' => $dataUser['prenom'],
            'email' => $dataUser['email'],
            'password' => Hash::make($dataUser['password']),
            'role' => $dataUser['role'],
        ]);
        
        if($user->role === 'acheteur')
        {
            $client = Client::create([
                'user_id' => $user->id
            ]);
            
        }
        else if($user->role === 'artiste')
        {
            $dataArtiste = $request->validate([
                'nom_d_artiste' => 'nullable|string|max:255',
                'bio'   => 'nullable|string',
                'photo' => 'nullable|string|max:255',
                'iban' => 'nullable|string|max:255',
                'a_la_une' => 'required|boolean',
                'Est_Artiste_Art3f' => 'required|boolean',
                'CV' => 'nullable|string|max:255',
                'localisations_id' => 'nullable|exists:localisations,id',
            ]);
            
            $artiste = Artiste::create([
                'user_id' => $user->id,
                'nom_d_artiste' => $dataArtiste['nom_d_artiste'],
                'bio' => $dataArtiste['bio'],
                'photo' => $dataArtiste['photo'],
                'iban' => $dataArtiste['iban'],
                'a_la_une' => $dataArtiste['a_la_une'],
                'Est_Artiste_Art3f' => $dataArtiste['Est_Artiste_Art3f'],
                'CV' => $dataArtiste['CV'],
                'localisations_id' => $dataArtiste['localisations_id'],
            ]);
            
        }
        
        $token = $user->createToken('api')->plainTextToken;
        return (new UserResource($user))->additional([
            'token' => $token,
        ]);
    }

}
