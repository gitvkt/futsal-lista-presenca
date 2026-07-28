# 🚀 Guia de Instalação e Configuração

Guia passo a passo para instalação e implantação do sistema em ambientes de hospedagem cPanel / Apache.

---

## ⚙️ Pré-requisitos

* **Servidor Web:** PHP 7.4 ou superior (extensão `pdo_mysql` habilitada).
* **Banco de Dados:** MySQL / MariaDB.
* **Acesso ao Servidor:** Gerenciador de Arquivos do cPanel ou acesso via FTP/SSH.

---

## 🛠️ Passo a Passo para Instalação

### 1. Upload dos Arquivos
1. Envie todos os arquivos do projeto para o diretório raiz da sua hospedagem (ex: `public_html`).
2. Garanta que o arquivo de estrutura do banco de dados na raiz do projeto esteja renomeado como **`schema.sql`**.

---

### 2. Criação do Banco de Dados no cPanel
1. Acesse o **cPanel** e abra o menu **Bancos de Dados MySQL**.
2. Crie um novo banco de dados (ex: `usuario_futsal`).
3. Crie um novo usuário MySQL e defina uma senha forte.
4. Associe o usuário ao banco de dados criado e marque a opção **Todos os Privilégios**.

---

### 3. Execução do Assistente Web
1. Acesse o diretório de instalação através do seu navegador:
   ```text
   [https://seusite.com.br/install/](https://seusite.com.br/install/)


Como o arquivo principal é o index.php, o assistente será carregado automaticamente ao acessar a pasta.

Preencha as credenciais solicitadas no formulário:

Host: localhost (ou o IP/host do seu servidor MySQL)

Nome do Banco: Nome completo do banco de dados criado no cPanel.

Usuário do Banco: Usuário atribuído ao banco de dados.

Senha do Banco: Senha do usuário MySQL.

Usuário Admin: Nome para login no painel administrativo (padrão: admin).

Senha Admin: Senha de acesso do administrador.

Clique no botão "Instalar e Configurar".

---

### 🤖 Processos Automatizados pelo Instalador:
[x] Banco de Dados: Importação automática da estrutura de tabelas do schema.sql.

[x] Administrador: Cadastro da conta admin com senha criptografada via password_hash.

[x] Configuração: Geração dinâmica do arquivo conexao.php na raiz do projeto.

[x] Segurança: Criação do arquivo de bloqueio install/installed.lock.


---

### 🔒 Ações de Segurança Pós-Instalação
[!IMPORTANT]
Após concluir a instalação e confirmar que o sistema está funcionando, execute os seguintes passos de segurança:

[ ] Remover o Instalador: Apague a pasta /install do servidor via cPanel ou FTP para evitar execuções indevidas.

[ ] Permissões de Arquivo: Certifique-se de que o arquivo conexao.php esteja configurado com a permissão de leitura 0644.


---

### 🔄 Como Forçar uma Reinstalação
Se precisar refazer o processo de instalação do zero:

Exclua o arquivo conexao.php localizado na raiz do projeto.

Exclua o arquivo install/installed.lock.


---

### 
Acesse novamente no navegador a URL:

Plaintext
[https://seusite.com.br/install/](https://seusite.com.br/install/)
