<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CotacaoController;


    Route::get('/', [CotacaoController::class, 'index']);
    Route::post('/consulta', [CotacaoController::class, 'consultaAPIAjax'])->name('consulta_cotacao');
    Route::post('/cotacao', [CotacaoController::class, 'processaCotacao'])->name('cotacao');
    Route::get('/cotacao/detalhe:simbolo', [CotacaoController::class, 'cotacaoDetalhe'])->name('cotacao_detalhe');

    Auth::routes();
