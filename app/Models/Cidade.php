<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cidades';

    protected $fillable = [
        'nome'
    ];

    public function bairros()
    {
        return $this->hasMany(Bairro::class, 'cidade_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'cidade_id');
    }
}
