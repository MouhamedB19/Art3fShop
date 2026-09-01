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
use App\Models\Ville;
use App\Models\Localisation;
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

        return (new UserResource($user))->additional(['token' => $token, 'code' => 200]);
    }

    public function index()
    {
        $user = Auth::user();
        return new UserResource($user)->additional(['code'=> 200]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie',
            'code' => 200
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
                'localisations_id' => 'required | exists:localisation, id'
            ]);

            $dataLocalisation = $request->validate([
                'code_postal' => 'required|string',
                'adresse' => 'required | string',
            ]);

            $dataVille = $request->validate([
                'nom_ville' => 'required|string',
                'pays' => 'required | exists:pays, id'
            ]);

            $ville = Ville::findOrCreate([
                'nom_ville' => $dataVille['nom_ville'],
                'pays' => $dataVille['pays']
            ]);

            $localisation = Localisation::findOrCreate([
                'code_postal' => $dataLocalisation['code_postal'],
                'adresse' => $dataLocalisation['adresse'],
                'ville_id' => $ville->id
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
                'localisations_id' => $localisation->id,
            ]);
            
        }
        
        $token = $user->createToken('api')->plainTextToken;
        return (new UserResource($user))->additional([
            'token' => $token,
            'code' => 200
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $dataUser = $request->validate([
            'nom' => ['sometimes', 'string', 'max:255'],
            'prenom' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'password' => ['sometimes', 'confirmed', Rules\Password::defaults()],
        ]);

        if($user->role === 'artiste'){
            $dataArtiste = $request->validate([
                'nom_d_artiste' => 'sometimes|string|max:255',
                'bio'   => 'sometimes|string',
                'photo' => 'sometimes|string|max:255',
                'iban' => 'sometimes|string|max:255',
                'a_la_une' => 'sometimes|boolean',
                'Est_Artiste_Art3f' => 'sometimes|boolean',
                'CV' => 'sometimes|string|max:255',  
                'localisations_id' => 'sometimes|exists:localisations,id',
            ]);

            $dataLocalisation = $request->validate([
                'code_postal' => 'sometimes|string',
                'adresse' => 'sometimes | string',
            ]);

            $dataVille = $request->validate([
                'nom_ville' => 'sometimes|string',
                'pays' => 'sometimes | exists:pays, id'
            ]);

            if($dataVille)
            {
                $ville = $user->artiste->localisation->ville->update([
                    'nom_ville' => $dataVille['nom_ville'],
                    'pays' => $dataVille['pays']
                ]);
            }
            if($dataLocalisation)
            {
                $localisation = $user->artiste->localisation->update([
                    'code_postal' => $dataLocalisation['code_postal'],
                    'adresse' => $dataLocalisation['adresse'],
                    'ville_id' => $ville->id
                ]);
            }
            

            
            $user->artiste->update([
                'nom_d_artiste' => $dataArtiste['nom_d_artiste'] ?? $user->artiste->nom_d_artiste,
                'bio' => $dataArtiste['bio'] ?? $user->artiste->bio,
                'photo' => $dataArtiste['photo'] ?? $user->artiste->photo,
                'iban' => $dataArtiste['iban'] ?? $user->artiste->iban,
                'a_la_une' => $dataArtiste['a_la_une'] ?? $user->artiste->a_la_une,
                'Est_Artiste_Art3f' => $dataArtiste['Est_Artiste_Art3f'] ?? $user->artiste->Est_Artiste_Art3f,
                'CV' => $dataArtiste['CV'] ?? $user->artiste->CV,
                'localisations_id' => isset($localisation) ? $localisation->id : $user->artiste->localisations_id,
            ]);
        }
        $user->update($dataUser);
        return new UserResource($user)->additional(['code' => 200]);
    }

}
