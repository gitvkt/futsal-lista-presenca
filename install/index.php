<?php
session_start();

$caminho_conexao = '../conexao.php';
$caminho_sql = '../schema.sql';
$trava_instalacao = 'installed.lock';

// 1. Bloqueio de Segurança: Se já instalado, interrompe a execução
if (file_exists($trava_instalacao) || file_exists($caminho_conexao)) {
    die("
        <div style='font-family:sans-serif; text-align:center; padding: 50px; background:#0f172a; color:#f8fafc; min-height:100vh;'>
            <h1 style='color:#ef4444;'>Sistema Já Instalado!</h1>
            <p>Para executar a instalação novamente, remova a pasta <strong>install/</strong> ou exclua os arquivos <strong>conexao.php</strong> e <strong>install/installed.lock</strong>.</p>
            <a href='../index.html' style='color:#38bdf8;'>Ir para o Sistema</a>
        </div>
    ");
}

$mensagem = '';
$erro = false;

// 2. Processa o Formulário de Instalação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = trim($_POST['db_host'] ?? 'localhost');
    $db_name = trim($_POST['db_name'] ?? '');
    $db_user = trim($_POST['db_user'] ?? '');
    $db_pass = $_POST['db_pass'] ?? '';

    $admin_user = trim($_POST['admin_user'] ?? 'admin');
    $admin_pass = $_POST['admin_pass'] ?? '';

    if (empty($db_name) || empty($db_user) || empty($admin_pass)) {
        $erro = true;
        $mensagem = "Preencha todos os campos obrigatórios!";
    } else {
        try {
            // Conecta ao servidor MySQL com as credenciais informadas no formulário
            $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Cria o Banco de Dados se não existir
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$db_name`;");

            // Importa a estrutura SQL do arquivo schema.sql
            if (file_exists($caminho_sql)) {
                $sqlCommands = file_get_contents($caminho_sql);
                $pdo->exec($sqlCommands);
            } else {
                throw new Exception("O arquivo 'schema.sql' não foi encontrado no diretório raiz.");
            }

            // Cadastra/Atualiza o Administrador Inicial
            $hashSenha = password_hash($admin_pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha) VALUES (:user, :pass) ON DUPLICATE KEY UPDATE senha = :pass");
            $stmt->execute([':user' => $admin_user, ':pass' => $hashSenha]);

            // Monta e gera o arquivo conexao.php dinamicamente
            $db_host_esc = addslashes($db_host);
            $db_name_esc = addslashes($db_name);
            $db_user_esc = addslashes($db_user);
            $db_pass_esc = addslashes($db_pass);

            $conexao_conteudo = "<?php\n" .
            "// Prevenção estrita contra cache\n" .
            "header(\"Cache-Control: no-store, no-cache, must-revalidate, max-age=0\");\n" .
            "header(\"Cache-Control: post-check=0, pre-check=0\", false);\n" .
            "header(\"Pragma: no-cache\");\n\n" .
            "// Configurações do banco de dados (Geradas pelo Instalador)\n" .
            "\$host = '{$db_host_esc}';\n" .
            "\$dbname = '{$db_name_esc}';\n" .
            "\$user = '{$db_user_esc}';\n" .
            "\$pass = '{$db_pass_esc}';\n\n" .
            "try {\n" .
            "    \$pdo = new PDO(\"mysql:host=\$host;dbname=\$dbname;charset=utf8mb4\", \$user, \$pass, [\n" .
            "        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,\n" .
            "        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC\n" .
            "    ]);\n" .
            "} catch (PDOException \$e) {\n" .
            "    http_response_code(500);\n" .
            "    header(\"Content-Type: application/json; charset=UTF-8\");\n" .
            "    echo json_encode([\"erro_conexao\" => \$e->getMessage()]);\n" .
            "    exit;\n" .
            "}\n";

            file_put_contents($caminho_conexao, $conexao_conteudo);

            // Cria o arquivo de trava
            file_put_contents($trava_instalacao, 'INSTALADO_EM_' . date('Y-m-d H:i:s'));

            $mensagem = "Instalação concluída com sucesso!";
        } catch (PDOException $e) {
            $erro = true;
            $mensagem = "Erro no Banco de Dados: " . $e->getMessage();
        } catch (Exception $e) {
            $erro = true;
            $mensagem = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador - Futsal da Firma</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen p-4 font-sans">

    <div class="bg-slate-800 border border-slate-700/80 p-6 rounded-2xl max-w-md w-full shadow-2xl space-y-5">
        <div class="flex items-center justify-center gap-3 border-b border-slate-700/60 pb-4">
            <div class="bg-emerald-500/10 text-emerald-400 p-3 rounded-xl border border-emerald-500/20">
                <i class="fa-solid fa-futbol text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-200">Futsal da Firma</h2>
                <p class="text-xs text-slate-400">Assistente de Instalação cPanel</p>
            </div>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="p-4 text-xs rounded-xl border <?= $erro ? 'bg-rose-500/10 text-rose-300 border-rose-500/20' : 'bg-emerald-500/10 text-emerald-300 border-emerald-500/20' ?>">
                <p class="font-bold mb-1"><?= $erro ? 'Falha na Instalação' : 'Sucesso!' ?></p>
                <p><?= $mensagem ?></p>
                <?php if (!$erro): ?>
                    <a href="../index.html" class="inline-block mt-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2 rounded-xl transition">
                        Acessar o Sistema
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($mensagem) || $erro): ?>
        <form method="POST" class="space-y-4 text-xs">
            <!-- Configurações Banco de Dados -->
            <div class="space-y-2">
                <h3 class="font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-database"></i> Banco de Dados (cPanel)
                </h3>
                
                <div>
                    <label class="block mb-1 text-slate-300 font-medium">Servidor (Host):</label>
                    <input type="text" name="db_host" value="localhost" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block mb-1 text-slate-300 font-medium">Nome do Banco de Dados:</label>
                    <input type="text" name="db_name" placeholder="usuario_futsal" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500">
                    <span class="text-[10px] text-slate-500">No cPanel utilize o prefixo (ex: conta_futsal)</span>
                </div>

                <div>
                    <label class="block mb-1 text-slate-300 font-medium">Usuário do Banco:</label>
                    <input type="text" name="db_user" placeholder="usuario_user" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block mb-1 text-slate-300 font-medium">Senha do Banco:</label>
                    <input type="password" name="db_pass" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <hr class="border-slate-700/60 my-2">

            <!-- Credenciais de Administrador -->
            <div class="space-y-2">
                <h3 class="font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-user-shield"></i> Administrador do Sistema
                </h3>

                <div>
                    <label class="block mb-1 text-slate-300 font-medium">Usuário Admin:</label>
                    <input type="text" name="admin_user" value="admin" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block mb-1 text-slate-300 font-medium">Senha Admin:</label>
                    <input type="password" name="admin_pass" placeholder="Defina uma senha forte" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-slate-200 focus:outline-none focus:border-emerald-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 font-bold py-3 rounded-xl transition text-white text-xs flex items-center justify-center gap-2 shadow-lg mt-4">
                <i class="fa-solid fa-gears"></i> Instalar e Configurar
            </button>
        </form>
        <?php endif; ?>
    </div>

</body>
</html>