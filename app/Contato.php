<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'nome_contato',
        'email_contato',
        'link_facebook_contato',
        'link_linkedln_contato',
        'user_id'
    ];

    public function UserContato(){
        return $this->belongsTo(User::class);
    }
}
