🚀 Guia de Instalação e Atualização - Versão 5.0.1
Este guia contém as instruções passo a passo para instalar ou atualizar o Futsal da Firma em ambientes de hospedagem cPanel / Apache.

⚙️ Pré-requisitos
Servidor Web: PHP 7.4 ou superior (com extensão PDO MySQL habilitada).

Banco de Dados: Servidor MySQL / MariaDB.

Acesso ao cPanel / Gerenciador de Arquivos: Para upload dos arquivos e criação do banco de dados.

🛠️ Passo a Passo para Instalação Limpa
1. Upload dos Arquivos
Faça o upload dos arquivos do projeto para a pasta raiz do seu domínio (geralmente public_html).

Certifique-se de que o arquivo de estrutura do banco de dados na raiz se chama schema.sql.

2. Criação do Banco de Dados no cPanel
Acesse o cPanel e vá em Bancos de Dados MySQL.

Crie um novo banco de dados (ex: usuario_futsal).

Crie um novo usuário MySQL e defina uma senha forte.

Adicione o usuário ao banco de dados recém-criado e conceda TODOS OS PRIVILÉGIOS.

3. Execução do Instalador Web
Abra o navegador e acesse a pasta de instalação do seu site:

Plaintext
http://seusite.com.br/install/
(Como o arquivo principal agora se chama index.php, o carregamento do formulário será automático).

Preencha o formulário de instalação com:

Host: localhost (ou o IP do seu servidor MySQL).

Nome do Banco: O nome completo do banco de dados criado no cPanel.

Usuário do Banco: O usuário do banco de dados criado no cPanel.

Senha do Banco: A senha definida para o usuário do banco.

Usuário Admin: Nome de usuário para acessar o painel administrativo (padrão: admin).

Senha Admin: Defina uma senha forte para o acesso administrativo.

Clique em "Instalar e Configurar".

O assistente irá:

Criar as tabelas automaticamente usando o arquivo schema.sql.

Cadastrar o usuário administrador com a senha criptografada em hash.

Gerar o arquivo conexao.php na raiz com as credenciais gravadas corretamente.

Gerar a trava de segurança install/installed.lock.

🔒 Boas Práticas de Segurança Pós-Instalação
Após receber a mensagem de sucesso e testar o acesso ao sistema:

Remova a pasta de instalação: Apague ou renomeie a pasta /install via Gerenciador de Arquivos do cPanel para evitar tentativas de reconfiguração do sistema.

Verifique permissões: Certifique-se de que o arquivo conexao.php gerado na raiz tenha permissão de leitura adequada (0644).

🔄 Como Forçar uma Reinstalação (se necessário)
Caso precise executar o processo de instalação novamente do zero:

Apague o arquivo conexao.php localizado na raiz do projeto.

Apague o arquivo install/installed.lock.

Acesse novamente a URL [http://seusite.com.br/install/](http://seusite.com.br/install/).
