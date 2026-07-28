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
