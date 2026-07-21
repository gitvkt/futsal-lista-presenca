<?php
require_once 'conexao.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT id, nome FROM jogadores ORDER BY id ASC");
        $jogadores = $stmt->fetchAll();
        echo json_encode($jogadores);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $acao = isset($data['acao']) ? $data['acao'] : '';

        // Autenticação com validação de Hash
        if ($acao === 'login') {
            $senhaInput = isset($data['senha']) ? $data['senha'] : '';

            $stmt = $pdo->prepare("SELECT id, senha FROM usuarios WHERE usuario = 'admin' LIMIT 1");
            $stmt->execute();
            $usuario = $stmt->fetch();

            // Verifica se o usuário existe e valida a senha enviada contra o Hash gravado
            if ($usuario && password_verify($senhaInput, $usuario['senha'])) {
                echo json_encode(["status" => "sucesso", "mensagem" => "Autenticado"]);
            } else {
                http_response_code(401);
                echo json_encode(["error" => "Senha incorreta"]);
            }
            exit;
        }

        // Inserção de jogador
        $nome = isset($data['nome']) ? trim($data['nome']) : '';

        if (!empty($nome)) {
            $stmt = $pdo->prepare("INSERT INTO jogadores (nome) VALUES (:nome)");
            $stmt->execute([':nome' => $nome]);
            echo json_encode(["status" => "sucesso", "id" => $pdo->lastInsertId()]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Nome inválido"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = isset($data['id']) ? intval($data['id']) : 0;

        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM jogadores WHERE id = :id");
            $stmt->execute([':id' => $id]);
            echo json_encode(["status" => "sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID inválido"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido"]);
        break;
}
?>