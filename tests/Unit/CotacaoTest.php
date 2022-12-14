<?php
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Middleware\ThrottleRequests;


/**
 * Princípios de um bom teste
 *
 * Fast: O teste deve ser rápido, permitindo que seja realizado várias vezes e a todo momento;
 * Independent: Ele deve ser independente, a fim de evitar que cause efeito cascata quando da ocorrência de uma falha – o que dificulta a análise dos problemas;
 * Repeatable: Deve permitir a repetição do teste diversas vezes e em ambientes diferentes;
 * Self-Validation: Os testes bem escritos retornam com as respostas true ou false, justamente para que a falha não seja subjetiva;
 * Timely: Os testes devem seguir à risca o critério de pontualidade. Além disso, o ideal é que sejam escritos antes do próprio código, pois evita que ele fique complexo demais para ser testado.

 */

class CotacaoTest extends \Tests\TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use WithFaker;


    protected function _before(UnitTester $i)
    {
    }

    protected function _after(UnitTester $i)
    {
    }

    // tests
    public function testGravaHistoricoCotacao()
    {
        $historico = factory(\App\Models\Historico::class)->make();
        $historicoModel = new \App\Repositories\HistoricoRepository(new \App\Models\Historico());
        $create = $historicoModel->create($historico->toArray());

        $this->assertDatabaseHas('historico_cotacoes',[
            'simbolo'=>$create->simbolo,
            'organizacao'=>$create->organizacao,
            'ultimo_preco'=>$create->ultimo_preco,
            'volume'=>$create->volume,
            'moeda'=>$create->moeda,
            'abertura'=>$create->abertura,
            'fechamento'=>$create->fechamento,
        ]);

    }

    public function testVerificaHistoricoCotacao()
    {
        //Caminho Feliz
        $historicoModel = new \App\Repositories\HistoricoRepository(new \App\Models\Historico());
        $dados = $historicoModel->find(['simbolo' => 'FBI'])->toArray();
        $this->assertNotEmpty($dados, 'O retorno não é um array');

        //Caminho Triste
        $dados = $historicoModel->find(['simbolo' => 'FBIs'])->toArray();
        $this->assertEmpty($dados, 'O retorno não é um array');

    }

    public function testVerificaHistoricoCotacaoExpirada()
    {
        //Caminho Feliz
        $historicoModel = new \App\Repositories\HistoricoRepository(new \App\Models\Historico());
        $dados = $historicoModel->find(['simbolo' => 'FBI'])->toArray();

        $agora = Carbon::now()->format('Y-m-d H:i');
        $date = Carbon::parse($dados[0]['created_at'])->addMinute(5)->setTimezone('America/Sao_Paulo')->format('Y-m-d H:i');
        $this->assertTrue($date > $agora, 'A data não deveria estar espirada');

        //Caminho Triste
        $date = Carbon::parse($dados[0]['created_at'])->subHours(16)->setTimezone('America/Sao_Paulo')->format('Y-m-d H:i');
        $this->assertFalse($date > $agora, 'A data deveria estar espirada');

    }

    public function testBuscaCotacaoApi()
    {
        $dadosRequest = ['simbolo'=>'aapl','_token' => csrf_token()];
        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->call('POST', route('consulta_cotacao'),$dadosRequest);
        $body = $response->content();
        $this->assertNotNull($body, 'Não deveria ser nulo');
        $this->assertEquals(200, $response->status(), 'Deveria retornar 200');

        $response2 = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->call('POST', route('consulta_cotacao'),[]);
        $this->assertNotEquals(200, $response2->status(), 'Não Deveria retornar 200');
    }
}