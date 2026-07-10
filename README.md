# Art3fShop

Plateforme e-commerce permettant à des artistes de vendre leurs œuvres en ligne. Projet réalisé dans le cadre d'un stage chez Art3f (salon d'art contemporain, Mulhouse).

## Stack technique

- **Backend** : Laravel
- **Frontend** : Blade, Tailwind CSS, Alpine.js, Livewire
- **Base de données** : MySQL
- **Recherche** : Meilisearch (via Laravel Scout)
- **Environnement local** : XAMPP (Windows)

## Installation / Lancement

1. Cloner le repo et se placer dans le dossier du projet
2. Installer les dépendances :
   ```bash
   composer install
   npm install
   ```
3. Copier le fichier d'environnement et générer la clé d'application :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configurer la base de données dans `.env` (nom de la base : `art3f`)
5. Lancer les migrations et les seeders :
   ```bash
   php artisan migrate --seed
   ```
6. Lancer Meilisearch et importer les index :
   ```bash
   php artisan scout:import "App\Models\Oeuvre"
   php artisan scout:import "App\Models\Artiste"
   php artisan scout:import "App\Models\Categorie"
   ```
7. Compiler les assets et démarrer le serveur :
   ```bash
   npm run dev
   php artisan serve
   ```

## Identifiants de test

| Rôle    | Email                          | Mot de passe |
|---------|---------------------------------|---------------|
| Admin   | admin@art3f.test               | TheAdmin68    |
| Client  | marie.moreau@example.com       | password      |
| Artiste | sophie.martin@art3f.test       | password      |

## Fonctionnalités implémentées

- Authentification (client / artiste, inscription et connexion)
- Espace artiste (dashboard, gestion de ses œuvres/tirages)
- Upload d'image pour une œuvre (1 image par œuvre)
- Catalogue d'œuvres avec filtres dynamiques (Livewire)
- Recherche dynamique (Meilisearch / Scout)
- Fiche œuvre / tirage
- Index des artistes avec recherche possible
- Fil d'Ariane
- Artistes à la une
- Panier
- Favoris
- Coupons / réductions
- Tunnel de commande (checkout)
- Paiement simulé
- Historique des commandes (côté client)
-  Conversations entre le client et l'artiste
- Emails transactionnels (driver log)
- Messagerie / conversations
- Consentement cookies RGPD (5 catégories)
- Espace admin (dashboard, gestion des utilisateurs, statistiques, suppression, création d'admin)
- Header responsive

## Fonctionnalités non implémentées

- **Paiement réel** (Stripe/PayPal) — volontairement simulé pour la démo
- **Upload multi-images par œuvre** — limité à une seule image par œuvre. Il s'agit d'une limite technique liée au choix de stockage (fichiers locaux plutôt qu'un service cloud adapté), qui pourrait être améliorée par une relation one-to-many `Oeuvre` → `images` couplée à un stockage cloud (type S3).
- Changement de langues et de devises (problèmes de conversion)
- Suivi de livraison
- Modification des informations personnelles
- Connexion avec Google et Facebook simulée (pas de connexion réelle)
- Gestion des abonnements à la newsletter et des sélections
- Banderole de promotion des salons
- Pages secondaires dont les liens sont dans le pied de page (ex: page FAQ)
- Gestion des emplacements publicitaires pour les artistes

## Structure du projet

- `role` enum sur `users` : `acheteur`, `artiste`, `admin`
- Tables de profil séparées : `Client`, `Artiste`
- Adresses normalisées : `Localisation → Ville → Pays`
- Tirages : œuvres physiques uniques 
- Toutes les routes sont définies dans `routes/web.php`
