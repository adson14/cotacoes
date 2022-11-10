<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acao extends Model
{
    protected $fillable = ['moeda_id','nome','ultima_cotacao'];
    protected $table = 'moedas';

    protected $primaryKey = 'moeda_id';

    protected  $dates = [
        'created_at',
        'updated_at'
    ];


    public static function getCurrencySimbol($currency){

        $simbolo = '';

        switch($currency){
            case 'USD':
                $simbolo = '$';
                break;
            case 'EUR':
                $simbolo = '€';
                break;
            default:
                $simbolo = 'R$';
                break;
        }

        return $simbolo;
    }

    public static function getTaxas($tipo,$valor){

        $taxaPagamento = 0.0;
        $taxaConversao = 1;

        switch($tipo){
            case 'Boleto':
                $taxaPagamento = 1.45;
            break;
            default:
                $taxaPagamento = 7.63;
            break;
        }

        if($valor < 3000){
            $taxaConversao = 2;
        }

        return array("Taxa_pagamento"=>$taxaPagamento,"Taxa_conversao"=>$taxaConversao);
    }
}
