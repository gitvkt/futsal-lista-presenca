<?php
header('Content-Type: application/json; charset=UTF-8');
require_once 'conexao.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        // Buscar jogadores com o valor individual pago
        $stmt = $pdo->query("SELECT id, nome, COALESCE(valor_pago, 0.00) AS valor_pago FROM jogadores ORDER BY id ASC");
        $jogadores = $stmt->fetchAll();

        // Buscar custo da quadra
        $stmtQuadra = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'valor_quadra'");
        $valorQuadra = $stmtQuadra->fetchColumn() ?: 0.00;

        // Buscar pagamentos efetuados para a quadra
        $stmtPag = $pdo->query("SELECT id, descricao, valor, DATE_FORMAT(criado_em, '%d/%m %H:%i') as data FROM pagamentos_quadra ORDER BY id DESC");
        $pagamentos = $stmtPag->fetchAll();

        // Total pago à quadra
        $totalPagoQuadra = array_sum(array_column($pagamentos, 'valor'));

        echo json_encode([
            'jogadores' => $jogadores,
            'valor_quadra' => (float)$valorQuadra,
            'pagamentos_quadra' => $pagamentos,
            'total_pago_quadra' => (float)$totalPagoQuadra
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'POST') {
    $acao = $input['acao'] ?? '';

    if ($acao === 'salvar_quadra') {
        $valor = (float)($input['valor'] ?? 0);
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('valor_quadra', :v) ON DUPLICATE KEY UPDATE valor = :v");
        $stmt->execute([':v' => $valor]);
        echo json_encode(['status' => 'success']);
        exit;
    }

    if ($acao === 'pagar_parcela') {
        $valor = (float)($input['valor'] ?? 0);
        $desc = trim($input['descricao'] ?? 'Parcela Quadra');
        $stmt = $pdo->prepare("INSERT INTO pagamentos_quadra (descricao, valor) VALUES (:d, :v)");
        $stmt->execute([':d' => $desc, ':v' => $valor]);
        echo json_encode(['status' => 'success']);
        exit;
    }

    if ($acao === 'editar_jogador') {
        $id = (int)($input['id'] ?? 0);
        $valor = (float)($input['valor'] ?? 0);
        $stmt = $pdo->prepare("UPDATE jogadores SET valor_pago = :v WHERE id = :id");
        $stmt->execute([':v' => $valor, ':id' => $id]);
        echo json_encode(['status' => 'success']);
        exit;
    }

    $nome = trim($input['nome'] ?? '');
    $valorInicial = isset($input['valor_pago']) ? (float)$input['valor_pago'] : 0.00;

    if (!empty($nome)) {
        $stmt = $pdo->prepare("INSERT INTO jogadores (nome, valor_pago) VALUES (:nome, :valor)");
        $stmt->execute([':nome' => $nome, ':valor' => $valorInicial]);
        echo json_encode(['status' => 'success']);
        exit;
    }
}

if ($method === 'DELETE') {
    $tipo = $input['tipo'] ?? 'jogador';
    $id = (int)($input['id'] ?? 0);

    if ($tipo === 'parcela') {
        $stmt = $pdo->prepare("DELETE FROM pagamentos_quadra WHERE id = :id");
    } else {
        $stmt = $pdo->prepare("DELETE FROM jogadores WHERE id = :id");
    }
    $stmt->execute([':id' => $id]);
    echo json_encode(['status' => 'success']);
    exit;
}
