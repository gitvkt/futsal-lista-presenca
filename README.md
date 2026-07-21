# ⚽ Futsal da Firma - Lista de Presença & Arrecadação

Aplicação web simples, ágil e responsiva para gerenciamento de listas de presença e arrecadação de jogos de futsal. 

O projeto conta com interface em **Tailwind CSS**, armazenamento dinâmico com **MySQL** e um painel restrito para administração com validação segura via hash de senha no PHP.

---

## 🚀 Funcionalidades

- **Lista em Tempo Real:** Exibição dos jogadores confirmados na rodada.
- **Cálculo Automático de Arrecadação:** Soma automática do valor arrecadado com base na taxa individual por jogador.
- **Chave Pix Integrada:** Facilitador para cópia da chave Pix e redirecionamento direto para o WhatsApp do organizador com o comprovante.
- **Painel Administrativo Restrito:** Área restrita por senha criptografada para adicionar e remover jogadores da lista.
- **Anti-Cache Forçado:** Configurações no cabeçalho HTTP e meta tags para garantir que o navegador receba os dados atualizados a cada requisição.

---

## 🛠️ Tecnologias Utilizadas

- **Front-end:** HTML5, JavaScript (ES6+), [Tailwind CSS (CDN)](https://tailwindcss.com/) e Font Awesome.
- **Back-end:** PHP (PDO).
- **Banco de Dados:** MySQL.

---

## 📁 Estrutura do Projeto

<img width="500" height="910" alt="futsalphp" src="https://github.com/user-attachments/assets/dc75decc-509a-4366-a39d-413b96fcd212" />



```text
.
├── api.php                  # API REST (GET, POST, DELETE) para autenticação e gestão de jogadores
├── conexao.php.example      # Exemplo de configuração de conexão com o banco de dados
├── favicon.png              # Ícone do projeto
├── index.html               # Interface principal e modais de gerenciamento
├── preview_site.png         # Imagem de pré-visualização (Open Graph)
└── schema.sql               # Estrutura e massa inicial de dados para o MySQL

