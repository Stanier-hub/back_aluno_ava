<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\MateriasController;
use App\Http\Controllers\AulasController;
use App\Http\Controllers\AtividadesController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\LivesController;
use App\Http\Controllers\PagWiseController;
use App\Http\Controllers\RespostaPerguntaController;
use App\Http\Controllers\NotasController;


use Laravel\Jetstream\Rules\Role;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// $this->middleware();
Route::group(['prefix' => 'v1'], function ($router) {

    // rotas para login
    Route::group([
        //'middleware' => 'auth:api',
        'prefix' => 'auth',


    ], function ($router) {

        Route::post('login', [AuthController::class, 'login'] );
        Route::post('logout', [AuthController::class, 'logout'] );
        Route::post('refresh', [AuthController::class, 'refresh'] );
        Route::post('me', [AuthController::class, 'me'] );

    });

    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'prefix' => 'materias',


    ], function ($router) {
        Route::post('dados_usu', [FuncionarioController::class, 'pegar_usuario'] );
        Route::get('tipo/andamento', [MateriasController::class, 'getMateriasAndamento'] );
  
        
    });

    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'prefix' => 'aulas',


    ], function ($router) {
        Route::get('andamento/{id_oferta_disciplina_turma}', [AulasController::class, 'getAulasAndamento'] );
        Route::get('videos/extra/andamento/{id_oferta_disciplina_turma}', [AulasController::class, 'getVideosAndamento'] );
        Route::get('material/andamento/{id_oferta_disciplina_turma}', [AulasController::class, 'getMateriaisAndamento'] );
  
        
    });

    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'prefix' => 'atividades',
    ], function ($router) {
        Route::get('andamento/{id_oferta_disciplina_turma}', [AtividadesController::class, 'getAtividades'] );
        Route::get('perguntas/{avaliacao_id}/{id_oferta_disciplina_turma}/{id_semestre_letivo}/{ead_avaliacao_oferta_disciplina}', [AtividadesController::class, 'getAtividadesPerguntas'] );
        Route::get('tentativas/{avaliacao_id}', [AtividadesController::class, 'listaTentativasAvaliacao'] );
        
     
    });
    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'prefix' => 'resposta_pergunta',
    ], function ($router) {
        Route::post('/criar', [RespostaPerguntaController::class, 'store'] );
        // Route::get('andamento/{id_oferta_disciplina_turma}', [AtividadesController::class, 'getAtividades'] );
        // Route::get('perguntas/{avaliacao_id}/{id_oferta_disciplina_turma}/{id_semestre_letivo}', [AtividadesController::class, 'getAtividadesPerguntas'] );
     
    });

    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'prefix' => 'notas',
    ], function ($router) {
        Route::get('/semestre', [NotasController::class, 'getSemestreAluno'] );
        Route::get('/semestre/{semestre_letivo_id}', [NotasController::class, 'getNotasAluno'] );

        // Route::get('andamento/{id_oferta_disciplina_turma}', [AtividadesController::class, 'getAtividades'] );
        // Route::get('perguntas/{avaliacao_id}/{id_oferta_disciplina_turma}/{id_semestre_letivo}', [AtividadesController::class, 'getAtividadesPerguntas'] );
     
    });



    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'namespace' => 'lives',
        'prefix' => 'lives',
        
    ], function ($router) {
        // Route::put('c/{id_oferta_disciplina_turma}', [MateriaisController::class, 'getMateriasAndamento'] );
        Route::get('andamento/{id_oferta_disciplina_turma}', [LivesController::class, 'getLives'] );
        Route::post('criar', [LivesController::class, 'createLives'] );
        
   
        
    });

    Route::group([
        //'middleware' => 'auth:api',
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'namespace' => 'financeiro',
        'prefix' => 'financeiro',
        
    ], function ($router) {
        // Route::put('c/{id_oferta_disciplina_turma}', [MateriaisController::class, 'getMateriasAndamento'] );
        Route::post('matricula/aluno', [FinanceiroController::class, 'show_join'] );
        Route::post('pagar', [PagWiseController::class, 'gerar_cobranca'] );
        Route::get('matricula/semestres/{id_matricula}', [FinanceiroController::class, 'getSemestreAluno'] );
        Route::get('pedidos/faturas/{semestre_leltivo_id}', [FinanceiroController::class, 'pegarPedidos'] );
        Route::get('pedidos/parcelas/{id_finan_pedido_recebimento}', [FinanceiroController::class, 'pegarParcelasPedido'] );
   
   
        
    });
    
    Route::group([
        //'middleware' => 'auth:api',
        // 'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'namespace' => 'pagwise',
        'prefix' => 'pagwise',
        
    ], function ($router) {
        Route::get('baixar_boletos', [PagWiseController::class, 'baixar_boletos'] );
            Route::get('baixar_pix', [PagWiseController::class, 'baixar_pix'] );

   
        
    });

    

});
    