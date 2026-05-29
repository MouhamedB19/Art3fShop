<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emplacement_pub extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'label',
        'format',
        'prix',
        'actif',
    ];

    public function campagnes(){
        return $this->hasMany(Campagne_pub::class, 'emplacement_id', 'code');
    }
}
