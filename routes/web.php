<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Artiste\ProfilArtisteController;
use Illuminate\Support\Facades\Route;
use App\Models\Ville;
use App\Http\Controllers\OeuvreController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\SelectionController;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;
use App\Http\Controllers\Auth\SocialiteController;

Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('auth.google.callback');

Route::get('/auth/facebook', [SocialiteController::class, 'redirectFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialiteController::class, 'callbackFacebook'])->name('auth.facebook.callback');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/artiste/completer-profil', [ProfilArtisteController::class, 'index'])
         ->name('artiste.completer-profil');
    Route::post('/artiste/completer-profil', [ProfilArtisteController::class, 'store'])
         ->name('artiste.completer-profil.store');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/compte', [CompteController::class, 'index'])->name('compte.index');

    Route::middleware('artiste')->group(function () {
        Route::get('/artiste/compte', [ArtisteController::class, 'compte'])->name('artiste.compte');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });

});

Route::get('/villes/{pays}', function($pays_id) {
    $villes = Ville::where('pays_id', '=',$pays_id)->get();
    return response()->json($villes);
})->name('villes.by.pays');

Route::middleware('auth')->group(function () {
    Route::resource('oeuvres', OeuvreController::class);
});

Route::get('/categories/{categorie}/sous-categories', function($categorie_id) {
    $sousCats = Categorie::where('id_categorie_parente', $categorie_id)->get();
    return response()->json($sousCats);
})->name('categories.sous-categories');
require __DIR__.'/auth.php';

Route::get('/categorie',[CatalogueController::class, 'index'])->name('catalogue.index');

Route::get('/catalogue/theme/{theme}', [CatalogueController::class, 'theme'])->name('catalogue.theme');
Route::get('/catalogue/{categorie}', [CatalogueController::class, 'categorie'])->name('catalogue.categorie');
Route::get('/artistes', [ArtisteController::class, 'index'])->name('artistes.index');
Route::get('/recherche', [UtilsController::class, 'recherche'])->name('recherche.index');
Route::get('/api/recherche', [UtilsController::class, 'rechercheApi'])->name('api.recherche');

Route::get('/a-propos', function(){
    return view('pages.about');
})->name('about');

Route::get('/cgv', function(){
    return view('pages.cgv');
})->name('cgv');

Route::get('/mentions-legales', function(){
    return view('pages.mentions-legales');
})->name('mentions-legales');

Route::get('/entreprises', function(){
    return view('pages.entreprises');
})->name('entreprises');

Route::get('/faq', function(){
    return view('faq.index');
})->name('faq.index');

Route::get('/contact', function(){
    return view('pages.contact');
})->name('contact');

Route::get('/emploi', function(){
    return view('pages.emploi');
})->name('emploi');

Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');

Route::get('/compte/favoris/oeuvres', [CompteController::class, 'favorisOeuvres'])->name('compte.favoris.oeuvres');
Route::get('/compte/favoris/artistes', [CompteController::class, 'favorisArtistes'])->name('compte.favoris.artistes');

Route::get('/locale/{locale}', [UtilsController::class, 'changeLocale'])->name('locale.switch');
Route::get('/devise/{devise}', [UtilsController::class, 'changeDevise'])->name('devise.switch');


Route::get('/cookies', function(){
    return view('cookies');
})->name('cookies'); // à vérifier
Route::get('/carte-cadeaux', function(){
    return view('pages.carte-cadeaux');
})->name('carte-cadeaux'); // à vérifier

Route::get('/selections', [SelectionController::class, 'index'])->name('selections.index');
Route::get('/selections/{slug}', [SelectionController::class, 'show'])->name('selections.show');
Route::get('/newsletter', function(){
    return view('pages.newsletter');
})->name('newsletter.page');

Route::get('/equipe', function(){
    return view('pages.equipe');
})->name('equipe');

Route::get('/oeuvre-sur-mesure', function(){
    return view('pages.oeuvre-sur-mesure');
})->name('oeuvre-sur-mesure');

Route::get('/criteres-selection', function(){
    return view('pages.criteres');
})->name('criteres');

Route::get('/designers-interieurs', function(){
    return view('pages.designer');
})->name('designers');

Route::get('/blog', function(){
    return view('pages.blog');
})->name('blog.index'); 
Route::post('/newsletter/subscribe', [UtilsController::class,'newsletterSubscribe'])->name('newsletter.subscribe');

Route::get('/artiste/inscription', [ArtisteController::class,'inscription'])->name('artiste.inscription');

Route::post('/artiste/inscription', [ArtisteController::class,'inscrire'])->name('artiste.inscrire');

Route::get('/oeuvres/{id}', [OeuvreController::class, 'show'])->name('oeuvre.show');








