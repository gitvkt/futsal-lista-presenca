<?php
// 1. VERIFICAÇÃO DE INSTALAÇÃO
// Se o arquivo conexao.php não existir, interrompe o carregamento e sinaliza para o instalador
if (!file_exists(__DIR__ . '/conexao.php')) {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(503);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Sistema não instalado. Por favor, acesse a pasta /install para realizar a configuração inicial.'
    ]);
    exit;
}

session_start(); // Inicia o controle de sessão seguro no servidor
require_once 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

// Criação automática de tabelas necessárias se não existirem
$pdo->exec("
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL
    );
    CREATE TABLE IF NOT EXISTS jogadores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        valor_pago DECIMAL(10,2) DEFAULT 0.00
    );
    CREATE TABLE IF NOT EXISTS configuracoes (
        chave VARCHAR(50) PRIMARY KEY,
        valor TEXT
    );
    CREATE TABLE IF NOT EXISTS pagamentos_quadra (
        id INT AUTO_INCREMENT PRIMARY KEY,
        descricao VARCHAR(100),
        valor DECIMAL(10,2) NOT NULL,
        data_pagamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS pendencias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        valor_devido DECIMAL(10,2) DEFAULT 0.00,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");

// Altera a coluna 'valor' para TEXT se ela tiver sido criada como DECIMAL originalmente
try {
    $pdo->exec("ALTER TABLE configuracoes MODIFY valor TEXT");
} catch (PDOException $e) {
    // Coluna já modificada ou erro ignorado
}

// Garante que exista pelo menos 1 admin padrão se a tabela estiver vazia
$stmtCheckAdmin = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
if ($stmtCheckAdmin->fetch()['total'] == 0) {
    $senhaHash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha) VALUES ('admin', ?)");
    $stmt->execute([$senhaHash]);
}

$method = $_SERVER['REQUEST_METHOD'];

// ==========================================
// FUNÇÃO DE VERIFICAÇÃO DE SEGURANÇA
// ==========================================
function verificarAutenticacao()
{
    if (empty($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
        http_response_code(403); // Acesso proibido
        echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso negado. Por favor, faça login.']);
        exit;
    }
}

if ($method === 'GET') {
    // A leitura dos dados (GET) é pública, todos podem ver o painel
    $jogadores = $pdo->query("SELECT * FROM jogadores ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'custo_quadra'");
    $custoQuadra = $stmt->fetchColumn();
    $custoQuadra = $custoQuadra !== false ? floatval($custoQuadra) : 0.00;

    $stmtSaldoAnterior = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'saldo_acumulado'");
    $saldoAcumulado = $stmtSaldoAnterior->fetchColumn();
    $saldoAcumulado = $saldoAcumulado !== false ? floatval($saldoAcumulado) : 0.00;

    $stmtPix = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'chave_pix'");
    $chavePix = $stmtPix->fetchColumn();
    $chavePix = $chavePix !== false ? $chavePix : '';

    $stmtWa = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'whatsapp'");
    $whatsapp = $stmtWa->fetchColumn();
    $whatsapp = $whatsapp !== false ? $whatsapp : '';

    $pagamentos = $pdo->query("SELECT * FROM pagamentos_quadra ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

    // Busca Histórico de Pendências Acumuladas
    $pendencias = $pdo->query("SELECT * FROM pendencias ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

    $stmtTotalPago = $pdo->query("SELECT SUM(valor) as total FROM pagamentos_quadra");
    $resTotalPago = $stmtTotalPago->fetch(PDO::FETCH_ASSOC);
    $totalPagoQuadra = $resTotalPago['total'] ?? 0.00;

    // Busca Administradores (Segurança: Só retorna se for admin logado)
    $admins = [];
    if (!empty($_SESSION['admin_logado'])) {
        $admins = $pdo->query("SELECT id, usuario FROM usuarios ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode([
        'jogadores' => $jogadores,
        'valor_quadra' => $custoQuadra,
        'saldo_acumulado' => $saldoAcumulado,
        'chave_pix' => $chavePix,
        'whatsapp' => $whatsapp,
        'total_pago_quadra' => floatval($totalPagoQuadra),
        'pagamentos_quadra' => $pagamentos,
        'pendencias_acumuladas' => $pendencias,
        'administradores' => $admins,
        'sessao_ativa' => !empty($_SESSION['admin_logado'])
    ]);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $acao = $data['acao'] ?? '';

    // Autenticação Admin (Acesso Público)
    if ($acao === 'login') {
        $usuario = trim($data['usuario'] ?? '');
        $senha = trim($data['senha'] ?? '');

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $userObj = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userObj && password_verify($senha, $userObj['senha'])) {
            $_SESSION['admin_logado'] = true;
            $_SESSION['usuario'] = $userObj['usuario'];
            echo json_encode(['sucesso' => true, 'usuario' => $userObj['usuario']]);
        } else {
            http_response_code(401);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário ou senha incorretos.']);
        }
        exit;
    }

    // Sair da conta (Logout)
    if ($acao === 'logout') {
        session_destroy();
        echo json_encode(['sucesso' => true]);
        exit;
    }

    // ========================================================
    // ABAIXO DESTA LINHA, APENAS ADMINISTRADORES PODEM AGIR
    // ========================================================
    verificarAutenticacao();

    if ($acao === 'salvar_chave_pix') {
        $chave = trim($data['chave_pix'] ?? '');
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('chave_pix', ?) ON DUPLICATE KEY UPDATE valor = ?");
        $stmt->execute([$chave, $chave]);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Chave PIX atualizada!']);
        exit;
    }

    if ($acao === 'salvar_whatsapp') {
        $wa = trim($data['whatsapp'] ?? '');
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('whatsapp', ?) ON DUPLICATE KEY UPDATE valor = ?");
        $stmt->execute([$wa, $wa]);
        echo json_encode(['sucesso' => true, 'mensagem' => 'WhatsApp atualizado!']);
        exit;
    }

    if ($acao === 'alterar_senha') {
        $usuario = trim($data['usuario'] ?? '');
        $novaSenha = trim($data['nova_senha'] ?? '');

        if (!$usuario || !$novaSenha) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
            exit;
        }

        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE usuario = ?");
        $stmt->execute([$hash, $usuario]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Senha alterada com sucesso!']);
        exit;
    }

    if ($acao === 'cadastrar_admin') {
        $novoUsuario = trim($data['novo_usuario'] ?? '');
        $novaSenha = trim($data['nova_senha'] ?? '');

        if (!$novoUsuario || !$novaSenha) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha usuário e senha.']);
            exit;
        }

        $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
            $stmt->execute([$novoUsuario, $hash]);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Novo administrador cadastrado!']);
        } catch (PDOException $e) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário já existe.']);
        }
        exit;
    }

    if ($acao === 'adicionar_jogador') {
        $nome = trim($data['nome'] ?? '');
        $valor = floatval($data['valor'] ?? 0);
        $stmt = $pdo->prepare("INSERT INTO jogadores (nome, valor_pago) VALUES (?, ?)");
        $stmt->execute([$nome, $valor]);
        echo json_encode(['sucesso' => true]);
        exit;
    }

    if ($acao === 'editar_jogador') {
        $id = intval($data['id'] ?? 0);
        $valor = floatval($data['valor'] ?? 0);
        $stmt = $pdo->prepare("UPDATE jogadores SET valor_pago = ? WHERE id = ?");
        $stmt->execute([$valor, $id]);
        echo json_encode(['sucesso' => true]);
        exit;
    }

    if ($acao === 'salvar_custo_quadra') {
        $valor = floatval($data['valor'] ?? 0);
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('custo_quadra', ?) ON DUPLICATE KEY UPDATE valor = ?");
        $stmt->execute([strval($valor), strval($valor)]);
        echo json_encode(['sucesso' => true]);
        exit;
    }

    if ($acao === 'pagar_parcela_quadra') {
        $valor = floatval($data['valor'] ?? 0);
        $descricao = trim($data['descricao'] ?? 'Pagamento Quadra');
        $stmt = $pdo->prepare("INSERT INTO pagamentos_quadra (descricao, valor) VALUES (?, ?)");
        $stmt->execute([$descricao, $valor]);
        echo json_encode(['sucesso' => true]);
        exit;
    }

    if ($acao === 'quitar_pendencia') {
        $id = intval($data['id'] ?? 0);
        $valorPago = floatval($data['valor_pago'] ?? 0);

        if ($id <= 0 || $valorPago <= 0) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Valor de pagamento inválido.']);
            exit;
        }

        // 1. Busca saldo acumulado atual
        $stmtSaldo = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'saldo_acumulado'");
        $saldoAtual = $stmtSaldo->fetchColumn();
        $saldoAtual = $saldoAtual !== false ? floatval($saldoAtual) : 0.00;

        // 2. Soma o valor recebido ao saldo acumulado
        $novoSaldo = $saldoAtual + $valorPago;
        $stmtUpdateSaldo = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('saldo_acumulado', ?) ON DUPLICATE KEY UPDATE valor = ?");
        $stmtUpdateSaldo->execute([strval($novoSaldo), strval($novoSaldo)]);

        // 3. Remove a pendência resolvida
        $stmtDel = $pdo->prepare("DELETE FROM pendencias WHERE id = ?");
        $stmtDel->execute([$id]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Pendência quitada com sucesso!']);
        exit;
    }

    if ($acao === 'finalizar_etapa') {
        // 1. Calcula o total arrecadado nesta etapa
        $stmtArrecadado = $pdo->query("SELECT SUM(valor_pago) as total FROM jogadores");
        $resArrecadado = $stmtArrecadado->fetch(PDO::FETCH_ASSOC);
        $arrecadadoEtapa = $resArrecadado['total'] ?? 0.00;

        // 2. Calcula o total pago à quadra nesta etapa
        $stmtPagoQuadra = $pdo->query("SELECT SUM(valor) as total FROM pagamentos_quadra");
        $resPagoQuadra = $stmtPagoQuadra->fetch(PDO::FETCH_ASSOC);
        $pagoQuadraEtapa = $resPagoQuadra['total'] ?? 0.00;

        // 3. Atualiza o saldo acumulado
        $stmtSaldoAnterior = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'saldo_acumulado'");
        $saldoAnterior = $stmtSaldoAnterior->fetchColumn();
        $saldoAnterior = $saldoAnterior !== false ? floatval($saldoAnterior) : 0.00;

        $novoSaldoAcumulado = ($saldoAnterior + $arrecadadoEtapa) - $pagoQuadraEtapa;

        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('saldo_acumulado', ?) ON DUPLICATE KEY UPDATE valor = ?");
        $stmt->execute([strval($novoSaldoAcumulado), strval($novoSaldoAcumulado)]);

        // 4. Migra os não pagantes (valor_pago == 0) para o histórico de pendências acumuladas
        $naoPagantes = $pdo->query("SELECT nome FROM jogadores WHERE valor_pago = 0.00")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($naoPagantes)) {
            $stmtInsertPendencia = $pdo->prepare("INSERT INTO pendencias (nome, valor_devido) VALUES (?, 10.00)");
            foreach ($naoPagantes as $np) {
                $stmtInsertPendencia->execute([$np['nome']]);
            }
        }

        // 5. Limpa a lista de presença e os pagamentos da quadra da etapa atual
        $pdo->exec("DELETE FROM jogadores");
        $pdo->exec("DELETE FROM pagamentos_quadra");

        echo json_encode(['sucesso' => true, 'novo_saldo' => floatval($novoSaldoAcumulado)]);
        exit;
    }

    if ($acao === 'zerar_caixa') {
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('saldo_acumulado', '0') ON DUPLICATE KEY UPDATE valor = '0'");
        $stmt->execute();
        echo json_encode(['sucesso' => true]);
        exit;
    }
}

if ($method === 'DELETE') {
    // Protege todas as rotas de exclusão
    verificarAutenticacao();

    $data = json_decode(file_get_contents('php://input'), true);
    $id = intval($data['id'] ?? 0);
    $tipo = $data['tipo'] ?? '';

    if ($tipo === 'jogador') {
        $stmt = $pdo->prepare("DELETE FROM jogadores WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true]);
        exit;
    } else if ($tipo === 'pagamento_quadra') {
        $stmt = $pdo->prepare("DELETE FROM pagamentos_quadra WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true]);
        exit;
    } else if ($tipo === 'pendencia') {
        $stmt = $pdo->prepare("DELETE FROM pendencias WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true]);
        exit;
    } else if ($tipo === 'admin') {
        $totalAdmins = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        if ($totalAdmins <= 1) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Não é possível excluir o único administrador.']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true]);
        exit;
    }

    echo json_encode(['sucesso' => false, 'mensagem' => 'Tipo inválido.']);
    exit;
}
