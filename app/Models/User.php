<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function artiste(){
        return $this->hasOne(Artiste::class);
    }

    
    public function client(){
        return $this->hasOne(Client::class);
    }
    
        
    public function estArtiste()
    {
        return $this->role === 'artiste' && $this->artiste() !== null;
    }

    public function estClient()
    {
        return $this->role === 'acheteur' && $this->client() !== null;
    }

    public function estAdmin()
    {
        return $this->role === 'admin';
    }
    

    public function newsletterSubscriber()
    {
        return $this->hasOne(NewsletterSubscriber::class);
    }

    public function commandes(){
        return $this->hasMany(Commande::class, 'user_id');
    }

    public function messages(){
        return $this->hasMany(Message::class,'emetteur_id');
    }

    public function nombreOeuvresFavoris(){
        return $this->client->oeuvres()->count();
    }

    public function nombreArtistesFavoris(){
        return $this->client->artistes()->count();
    }
}
