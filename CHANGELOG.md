# Changelog

Todas as alterações notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Versioning Semântico](https://semver.org/lang/pt-BR/2.0.0/).

## [Unreleased]

### A fazer
- Implementar exportação do relatório financeiro em PDF/CSV.

---

[5.0.1] - 2026-07-28
🚀 Melhorias & Novas Funcionalidades
Instalador Web Automatizado:

Atualizada a rota principal do assistente de instalação para install/index.php, eliminando a necessidade de digitar o arquivo explicitamente na URL.

Implementada a importação dinâmica do banco de dados a partir do arquivo estruturado schema.sql.

Criação automática e segura das credenciais administrativas iniciais durante o processo de instalação.

🐛 Correções de Erros (Bug Fixes)
Geração Dinâmica do conexao.php:

Corrigida a gravação das credenciais do banco de dados para evitar o uso de dados genéricos de exemplo.

Implementado tratamento de caracteres especiais nas senhas do MySQL (escape com addslashes) para prevenir quebras de sintaxe no PHP gerado.

Trava de Instalação e Tratamento de Exceções:

Ajustada a verificação de segurança no topo do api.php para interromper requisições JSON e alertar o usuário caso o sistema ainda não tenha sido instalado.

Aprimoradas as mensagens de erro e o fluxo de criação da trava installed.lock.

## [5.0.0] - 2026-07-28

### 🚀 Adicionado
- **Gestão de Pendências Acumuladas:** Novo painel para visualização e acompanhamento de dívidas de etapas anteriores.
- **Quitação de Dívidas:** Opção para dar baixa manual em pendências com soma/abatimento automático no Saldo Caixa.
- **Listagem de Inadimplentes da Etapa:** Seção dedicada no painel Admin para identificar rapidamente quem ainda não pagou no ciclo atual.
- **Ações Rápidas por Jogador:** Botões diretos para dar baixa, editar valores e remover lançamentos pendentes.

### 🔄 Modificado
- **Integração de Caixa:** As quitações de pendências passadas agora alimentam diretamente o fluxo do saldo do caixa.
- **Interface e Layout:** Refatoração completa das tabelas de controle admin em componentes Tailwind CSS otimizados e responsivos.

### 🛡️ Segurança
- Interceptação e tratamento de sessões expiradas (status HTTP 403) com fechamento automático dos recursos do painel administrativo.

## [4.4.0] - 2026-07-25

### Alterado
- **Interface (UI/UX):** Ocultada a exibição do selo/badge de "Pendente" para jogadores sem valor pago (`R$ 0,00`) na lista pública, mantendo o layout mais limpo sem afetar os cálculos de caixa.
- **Painel Admin:** Otimizada a renderização dinâmica dos dados e modais após ações de criação, edição ou exclusão, eliminando a necessidade de atualizar a página (`F5`).

### Corrigido
- **API Backend (`api.php`):** Ajustada a consulta SQL de pagamentos da quadra para ordenação e formatação correta do campo `criado_em`.
- **Tratamento de Erros:** Adicionado tratamento de exceção `PDOException` com respostas padronizadas em JSON (`HTTP status 500`).

---

## [4.3.0] - 2026-07-20

### Adicionado
- **Gestão Financeira Dinâmica:** Suporte ao lançamento de parcelas/etapas pagas à quadra (`pagamentos_quadra`) com cálculo automático de saldo do caixa em tempo real.
- **Edição Individual:** Funcionalidade no painel administrativo para editar o valor de contribuição por jogador diretamente na lista.
- **Identidade e Redes:** Rodapé unificado com créditos à VKT CLOUD e links para GitHub, LinkedIn, Instagram e Website.

---

## [4.0.0] - 2026-06-01

### Modificado
- **Arquitetura Geral:** Migração completa da camada de persistência de dados do Firebase (Firestore) para arquitetura própria com **PHP 8 + MySQL (PDO)**.
- **Interface Otimizada:** Refatoração visual completa com Tailwind CSS utilitário no modelo *Mobile-First*.

### Adicionado
- **Segurança:** Área administrativa protegida por autenticação para gestão de presencia e lançamentos.
- **Atalhos Rápidos:** Botão de cópia rápida para chave PIX e integração direta com WhatsApp para envio de comprovante.

---

[Unreleased]: https://github.com/gitvkt/futsal-lista-presenca/compare/v4.4.0...HEAD
[4.4.0]: https://github.com/gitvkt/futsal-lista-presenca/compare/v4.3.0...v4.4.0
[4.3.0]: https://github.com/gitvkt/futsal-lista-presenca/compare/v4.0.0...v4.3.0
[4.0.0]: https://github.com/gitvkt/futsal-lista-presenca/releases/tag/v4.0.0
