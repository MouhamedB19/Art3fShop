<?php

namespace App\Http\Controllers\Artiste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Localisation;
use App\Models\Pays;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Artiste;
class ProfilArtisteController extends Controller
{
    public function index()
    {
        $pays = Pays::all();
        $villes = Localisation::select('villes.id', 'villes.nom_ville')
            ->join('villes', 'localisations.ville_id', '=', 'villes.id')
            ->distinct()
            ->get();
        $categories = Categorie::whereNull('id_categorie_parente')->get();
        return view('artiste.completer-profil', [
            'pays' => $pays,
            'villes' => $villes,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bio'          => ['required', 'string'],
            'nom_d_artiste' => ['string', 'max:255'],
            'photo'        => ['required', 'image', 'max:2048'],
            'iban'         => ['required', 'string'],
            'cv'           => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'code_postal'  => ['required', 'string'],
            'adresse'       => ['required', 'string'],
            'ville_id'     => ['required', 'exists:villes,id'],
            'categories' => ['required', 'array'],
        ]);

        $photo = $request->file('photo')->store('photos/artistes', 'public');

        // Cherche ou crée la localisation
        $localisation = Localisation::firstOrCreate([
            'code_postal' => $request->code_postal,
            'adresse'     => $request->adresse,
            'ville_id'    => $request->ville_id,
        ]);
        


        $artiste = Artiste::firstOrCreate([
            'bio'              => $request->bio,
            'photo'            => $photo,
            'iban'             => $request->iban,
            'localisations_id' => $localisation->id,
            'nom_d_artiste'    => $request->nom_d_artiste,
            'user_id'         => Auth::id(),
            'cv'               => $request->file('cv')->store('cvs/artistes', 'public'),
        ]);
        $artiste->categories()->attach($request->categories);
        return redirect(route('dashboard'));
    }

    public function edit(){
        $user = Auth::user();
        $artiste = $user->artiste;
        $villes = Ville::orderBy('nom_ville')->get();
        $categories = Categorie::all();
        return view('artiste.edit-profil',compact('user','artiste','villes','categories'));
    }

    public function show(){
        $user = Auth::user();
        $artiste = $user->artiste;
        return view('artiste.index-profil',compact('user','artiste'));
    }

    public function update(Request $request){
        //dd($request->method(), $request->all());
        $user = Auth::user();
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'bio'          => ['required', 'string'],
            'nom_d_artiste' => ['string', 'max:255'],
            'photo'        => ['nullable', 'image', 'max:2048'],
            'iban'         => ['required', 'string'],
            'cv'           => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'code_postal'  => ['required', 'string'],
            'adresse'       => ['required', 'string'],
            'ville_id'     => ['required', 'exists:villes,id'],
            'categories' => ['required', 'array'],
        ]);
        DB::transaction(function() use ($request,$user){

            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                
            ]);
            
            if($request->filled('password')){
                $user->update(['password' => Hash::make($request->password)]);
            }

            $newlocation = Localisation::updateOrCreate([
                'code_postal' => $request->code_postal,
                'adresse' => $request->adresse,
                'ville_id' => $request->ville_id,
            ]);

            $user->artiste->update([
                'bio' => $request->bio,
                'nom_d_artiste' => $request->nom_d_artiste,
                'localisation_id' => $newlocation->id,
                'iban' => $request->iban,
            ]);
            if ($request->hasFile('cv')) {
                $user->artiste->update([
                    'cv' => $request->file('cv')->store('cvs/artistes', 'public'),
                ]);
            }

            if ($request->hasFile('photo')) {
                Storage::disk('public')->delete($user->artiste->photo);
                $photo = $request->file('photo')->store('photos/artistes', 'public');
                $user->artiste->update(['photo' => $photo]);
            }

            $user->artiste->categories()->sync($request->categories);
            
        });
        return redirect(route('artiste.index.profil'));
    }
}
