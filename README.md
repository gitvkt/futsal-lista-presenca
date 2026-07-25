# ⚽ Futsal da Firma — Lista de Presença & Gestão Financeira

<p align="center">
  <img width="500" alt="Pré-visualização do Futsal da Firma" src="https://github.com/user-attachments/assets/155292b9-e924-4ea0-bdad-450e3b5d52f7" />
</p>

Aplicação web leve, ágil e responsiva (*Single Page Application*) para gerenciamento de listas de presença e controle financeiro de partidas recreativas de futsal.

O projeto conta com interface em **Tailwind CSS**, consumo de API RESTful via **PHP (PDO)** e armazenamento persistente com **MySQL**, oferecendo controle em tempo real tanto para os jogadores quanto para o organizador.

---

## 🎓 Projeto Extensionista (Contexto Acadêmico)

Este repositório compõe um **Projeto Extensionista Universitário**, focado na aplicação prática da tecnologia para a solução de problemas organizacionais no âmbito comunitário.

* **Inovação e Transformação Digital:** Digitalização do processo informal de arrecadação e controle de presença em grupos esportivos locais.
* **Transparência Coletiva:** Prestação de contas clara em tempo real, exibindo arrecadação total, abates do custo do aluguel da quadra e saldo do caixa.
* **Inclusão e Acessibilidade:** Interface *Mobile-First* otimizada, que dispensa cadastros ou downloads de aplicativos por parte dos participantes.

---

## 🚀 Funcionalidades

### 👥 Para os Jogadores (Público)
- **Lista em Tempo Real:** Exibição dinâmica dos confirmados na rodada.
- **Transparência de Caixa:** Resumo visível do total arrecadado, valor pago pela quadra e saldo final do caixa.
- **Chave Pix Integrada:** Facilidade de cópia em um clique e botão direto para envio de comprovante via WhatsApp.

### 🛡️ Para o Organizador (Painel Admin)
- **Painel Restrito:** Área administrativa protegida por senha para gestão completa.
- **Gerenciamento de Presença:** Adição e remoção simplificada de jogadores.
- **Lançamento de Parcelas:** Registro de pagamentos efetuados à quadra (sinais, parcelas) com cálculo automático de abatimento.
- **Ajuste de Contribuições:** Edição individual dos valores pagos por cada jogador.
- **Anti-Cache Forçado:** Configurações no cabeçalho HTTP e meta tags para garantir a entrega de dados atualizados a cada requisição.

---

## 🛠️ Tecnologias Utilizadas

- **Front-end:** HTML5, JavaScript (Vanilla ES6+), [Tailwind CSS (CDN)](https://tailwindcss.com/) e Font Awesome.
- **Back-end:** PHP 8.x (API RESTful em JSON, PDO com prevenção contra SQL Injection).
- **Banco de Dados:** MySQL / MariaDB.

---

## 📁 Estrutura do Projeto

```text
.
├── api.php                 # API REST (GET, POST, DELETE) para gestão de dados
├── CHANGELOG.md            # Histórico de versões e atualizações do projeto
├── conexao.php.example     # Modelo de configuração de conexão com o banco de dados
├── favicon.png             # Ícone da aplicação
├── index.html              # Interface SPA e modais de gerenciamento
├── preview_site.png        # Imagem de pré-visualização (Open Graph)
└── schema.sql              # Estrutura do banco de dados e dados iniciais
