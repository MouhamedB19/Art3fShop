<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Artiste\ProfilArtisteController;
use Illuminate\Support\Facades\Route;
use App\Models\Ville;
use App\Models\Categorie;

use App\Http\Controllers\OeuvreController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ArtisteController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\FavorisController;

Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('auth.google.callback');

Route::get('/auth/facebook', [SocialiteController::class, 'redirectFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialiteController::class, 'callbackFacebook'])->name('auth.facebook.callback');

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');



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
        Route::get('/oeuvres/index',[OeuvreController::class,'index'])->name('oeuvres.index');
        Route::post('/oeuvres/edit/{oeuvre}',[OeuvreController::class,'edit'])->name('oeuvres.edit');

        Route::get('/artiste/edit/profil',[ProfilArtisteController::class,'edit'])->name('artiste.edit.profil');
        Route::get('/artiste/index/profil',[ProfilArtisteController::class,'show'])->name('artiste.index.profil');
        Route::put('/artiste/update/profil',[ProfilArtisteController::class,'update'])->name('artiste.update.profil');
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

Route::get('/artistes/{id}', [ArtisteController::class, 'show'])->name('artistes.show');
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

Route::post('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajout/{tirage}',[PanierController::class,'add'])->name('panier.ajout');
Route::get('/compte/favoris/oeuvres', [FavorisController::class, 'favorisOeuvres'])->name('compte.favoris.oeuvres');
Route::get('/compte/favoris/artistes', [FavorisController::class, 'favorisArtistes'])->name('compte.favoris.artistes');
Route::post('compte/favoris/handle/{tirage}',[FavorisController::class,'handleOeuvre'])->name('compte.favoris.oeuvres.handle');


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

Route::get('/oeuvres/{oeuvre}', [OeuvreController::class, 'show'])->name('oeuvres.show');
Route::get('/oeuvres/{oeuvre}/tirage/{tirage}',[OeuvreController::class,'showTirage'])->name('oeuvres.show.tirage');

Route::post('/oeuvres/create',[OeuvreController::class,'store'])->name('oeuvres.create');



Route::middleware(['auth'])->group(function () {

    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])
        ->name('conversations.show');
        
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])
        ->name('messages.store');

    Route::post('/conversations/{commande_id}/{artiste_id}', [ConversationController::class, 'store'])
        ->name('conversations.store');

    Route::get('/compte/conversations',[ConversationController::class,'index'])
        ->name('compte.conversations.index');

    Route::get('/compte/commandes',[CommandeController::class,'index'])
        ->name('compte.commandes.index');
        
    Route::get('/compte/commandes/{id}',[CommandeController::class,'show'])
        ->name('compte.commandes.show');

   
});

Route::middleware(['auth'])->prefix('panier')->name('panier.')->group(function () {
    Route::get('/', [PanierController::class, 'index'])->name('index');
    Route::post('/add/{tirage}', [PanierController::class, 'add'])->name('add');
    Route::delete('/remove/{tirage}', [PanierController::class, 'remove'])->name('remove');
    Route::delete('/clear', [PanierController::class, 'clear'])->name('clear');
});

Route::middleware(['auth'])->group(function(){
    Route::post('/coupon/check',[CouponController::class,'appliquer'])
        ->name('coupon.check');

    Route::delete('/coupon/retirer/{coupon}',[CouponController::class,'retirer'])
        ->name('coupon.retirer');
});


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CommandeController::class, 'create'])->name('compte.commandes.checkout');
    Route::post('/checkout', [CommandeController::class, 'store'])->name('checkout.store');
    Route::get('/commande/{commande}/confirmation', [CommandeController::class, 'confirmation'])->name('commande.confirmation');
});

Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/resume', [CheckoutController::class, 'resume'])
        ->name('resume');

    Route::get('/identification', [CheckoutController::class, 'identification'])
        ->name('identification');
    Route::post('/identification', [CheckoutController::class, 'storeIdentification'])
        ->name('identification.store');

    Route::get('/adresse', [CheckoutController::class, 'adresse'])
        ->name('adresse');
    Route::post('/adresse', [CheckoutController::class, 'storeAdresse'])
        ->name('adresse.store');

    Route::get('/livraison', [CheckoutController::class, 'livraison'])
        ->name('livraison');
    Route::post('/livraison', [CheckoutController::class, 'storeLivraison'])
        ->name('livraison.store');

    Route::get('/paiement', [CheckoutController::class, 'paiement'])
        ->name('paiement');

    Route::post('/paiement', [CheckoutController::class, 'storePaiement'])
        ->name('paiement.store');

    Route::get('/confirmation/{commande}', [CheckoutController::class, 'confirmation'])
        ->name('confirmation');
});

Route::get('api/recherche/',[RechercheController::class, 'suggestions'])
    ->name('recherche.suggestions');

Route::get('/recherche',[RechercheController::class,'index'])
    ->name('recherche.index');

