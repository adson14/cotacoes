<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = ['id','simbolo','organizacao','ultimo_preco','volume','moeda','abertura','fechamento'];
    protected $table = 'historico_cotacoes';

    protected $primaryKey = 'id';

    protected  $dates = [
        'created_at',
        'updated_at'
    ];

    

}
