<?php
declare(strict_types=1);
header('Content-Type: application/json');

require_once __DIR__ . '/../Database.php';
$pdo = Database::getConnection();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $sql = "SELECT * FROM contatos WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $contato = $stmt->fetch();
            if ($contato) {
                echo json_encode($contato);
            } else {
                http_response_code(404);
                echo json_encode(['erro' => 'Contato não encontrado']);
            }
            break;
        } else {
            $pag = (int) ($_GET['pagina'] ?? 1);
            $porPagina = 20;
            $offset = ($pag -1) * $porPagina;
            $sql = "SELECT * FROM contatos LIMIT :limite OFFSET :offset";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode($stmt->fetchAll());
            break;
        }

    case 'POST':
        $dados = json_decode(file_get_contents('php://input'), true);
        $nome = $dados['nome'];
        $email = $dados['email'];
        $telefone = $dados['telefone'];
        if(!$nome){
            http_response_code(400);
            echo json_encode(['erro' => 'nome não encontrado']);
            break;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            http_response_code(400);
            echo json_encode(['erro' => 'email não informado ou inválido']);
            break;
        }
        if(!$telefone){
            http_response_code(400);
            echo json_encode(['erro' => 'telefone não encontrado']);
            break;
        }
        $sql = "INSERT INTO contatos (nome, email, telefone, criado_em) VALUES (:nome, :email, :telefone, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email'   => $email,
            ':telefone' => $telefone,
        ]);
        $id = (int) $pdo->lastInsertId();
        http_response_code(201);
        echo json_encode(['id' => $id, 'nome' => $nome, 'email' => $email, 'telefone' => $telefone]);
        break;
    case 'PUT':
        $id = (int) ($_GET['id'] ?? 0);
        $dados = json_decode(file_get_contents('php://input'), true);
        $nome = $dados['nome'];
        $email = $dados['email'];
        $telefone = $dados['telefone'];
                if(!$nome){
            http_response_code(400);
            echo json_encode(['erro' => 'nome não encontrado']);
            break;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            http_response_code(400);
            echo json_encode(['erro' => 'email não informado ou inválido']);
            break;
        }
        if(!$telefone){
            http_response_code(400);
            echo json_encode(['erro' => 'telefone não encontrado']);
            break;
        }
        $sql = "UPDATE contatos SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone,
            ':id' => $id
        ]);
        http_response_code(200);
        echo json_encode(['Registro Alterado']);
        break;
    case 'DELETE':
        $id = (int) ($_GET['id'] ?? 0);
        $sql = "DELETE FROM contatos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        http_response_code(204);
        break;
}
