<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $fillable = [
        'tipo_telefone',
        'telefone',
        'contato_id'
    ];

    public function ContatoTelefone(){
        return $this->belongsTo(Contato::class);
    }
}
