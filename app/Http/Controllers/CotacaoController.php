<?php

namespace App\Http\Controllers;

use App\Mail\SendMailUser;
use App\Models\Config;
use App\Models\Historico;
use App\Models\Acao;
use App\Services\HistoricoService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CotacaoController extends Controller
{
    protected $historicoService;
    protected $client;

    /**
     * @param HistoricoService $service
     * Adson Souza - Aqui Utilizei o pattern repository e um pouco de Service layer
     */
    public function __construct(HistoricoService $service)
    {
        $this->historicoService = $service;
        $this->client = new Client();
    }

    public function index()
    {
        return view('index');
    }


    public function verificaCotacao(array $where = [])
    {
        return $this->historicoService->buscar($where);
    }

    protected function consultaAPI(string $uri)
    {
        $parametros = $this->montaAcesso();
        $key_api = env('API_KEY');

        $response = $this->client->request('GET', env('URL_API_SERVICE').$uri.'?token='.$key_api.$parametros);
        return json_decode($response->getBody()->getContents());
    }

    protected function consultaAPIAjax(Request $request)
    {
        $parametros = $this->montaAcesso();
        $uri = '/stock/'.$request->simbolo.'/quote';
        $key_api = env('API_KEY');
        $response = $this->client->request('GET', env('URL_API_SERVICE').$uri.'?token='.$key_api.$parametros);
        $dadosResponse = json_decode($response->getBody()->getContents());
        $dados = $this->formataRequest('api',$request,$dadosResponse);
        return response()->json($dados);
    }

    private function montaAcesso(array $filtros = []){
        $list = "";
        if(!empty($filtros)){
            foreach($filtros as $filtro){
                $list.= '&'.$filtro;
            }
        }
        return  $list;
    }

    public function processaCotacao(Request $request)
    {
        $dados = [];
        $date = Carbon::now()->format('Y-m-d H:i');
        $agora = Carbon::now()->format('Y-m-d H:i');
        $tipo_request = 'api';
        $dadosBanco = $this->verificaCotacao(['simbolo' => $request->simbolo]);
        if(!$dadosBanco->isEmpty()){
            $date = Carbon::parse($dadosBanco[0]->created_at)->addMinute(5)->format('Y-m-d H:i');
        }

        /*
         * Adson Souza
         * Existe um tempo de 5 minutos para atualização da cotação, se a última consulta gtravada já estiver
         * expirada então uma nova consulta será feita à API.
         * Necessário para evitar requisição desnecessárias e esgotar a cota de requisições
         */
        if(!$date > $agora){
            $dados = $dadosBanco[0];
            $tipo_request = 'banco';
        }else{
            $response = $this->consultaAPI('/stock/'.$request->simbolo.'/quote');
            //$ultima_atualizacao = date('Y-m-d', $response->latestUpdate);

            $date = new \DateTime();
            $date->setTimestamp(($response->latestUpdate / 1000));
            $ultima_atualizacao =  $date->format('Y-m-d H:i:s');

            $dados_a_gravar = [
                'simbolo'=>$response->symbol,
                'organizacao'=>$response->companyName,
                'ultimo_preco'=>$response->latestPrice,
                'volume'=>$response->volume,
                'moeda'=>$response->currency,
                'abertura'=>$response->open,
                'fechamento'=>$response->close,
                'ultima_atualizacao' => $ultima_atualizacao
            ];

            $dados = $this->gravaHistorico($dados_a_gravar);
        }
        $dados = $this->formataRequest($tipo_request,$request,$dados);
        return view('cotacao',['dados'=>$dados]);
    }

    public function gravaHistorico(array $dados_a_gravar)
    {
        return $this->historicoService->gravar($dados_a_gravar);
    }

    public function cotacaoDetalhe(Request $request)
    {
        $response = $this->consultaAPI('/stock/'.$request->simbolo.'/company');
        $request->request->add(['organizacao' => $response->companyName]);
        $request->request->add(['exchange' => $response->exchange]);
        $request->request->add(['ramo' => $response->sector]);
        $request->request->add(['site' => $response->website]);
        $request->request->add(['descricao' => $response->description]);
        $request->request->add(['simbolo' => $response->symbol]);
        $request->request->add(['ceo' => $response->CEO]);
        return view('detalhe',['dados'=>$request]);
    }

    public function formataRequest(string $tipo, Request $request, $response)
    {
        if($tipo=='api'){
            $request->request->add(['volume' => $response->volume ?? '-']);
            $request->request->add(['abertura' => $response->open ?? '-']);
            $request->request->add(['fechamento' => $response->close ?? '-']);
        }else{
            $request->request->add(['volume' => $response->volume ?? '-']);
            $request->request->add(['abertura' => $response->abertura ?? '-']);
            $request->request->add(['fechamento' => $response->fechamento ?? '-']);
        }

        $ultima_atualizacao = Carbon::parse($response->ultima_atualizacao)->format('d/m/Y');

        $request->request->add(['simbolo_moeda' => Acao::getCurrencySimbol($response->currency ?? $response->moeda)]);
        $request->request->add(['moeda' => $response->currency ?? $response->moeda]);
        $request->request->add(['organizacao' => $response->companyName ?? $response->organizacao]);
        $request->request->add(['ultimo_preco' => $response->latestPrice ?? $response->ultimo_preco]);
        $request->request->add(['ultima_atualizacao' => $ultima_atualizacao]);

        return $request;
    }

}
