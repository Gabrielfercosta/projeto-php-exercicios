<?php

declare(strict_types=1);

header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';
\Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->load();

use App\Config\Database;
use App\Repository\TarefaRepository;
use App\Service\TarefaService;
use App\Controller\TarefaController;
use App\Http\Router;

$pdo = Database::getConnection();
$repo = new TarefaRepository($pdo);
$service = new TarefaService($repo);
$controller = new TarefaController($service);

$router = new Router();

$router->get('/tarefas', [$controller, 'listar']);
$router->get('/tarefas/{id}', [$controller, 'buscar']);
$router->post('/tarefas', [$controller, 'criar']);
$router->put('/tarefas/{id}', [$controller, 'atualizar']);
$router->delete('/tarefas/{id}', [$controller, 'deletar']);

$router->dispatch();
