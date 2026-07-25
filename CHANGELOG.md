# Changelog

Todas as alterações notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Versioning Semântico](https://semver.org/lang/pt-BR/2.0.0/).

## [Unreleased]

### A fazer
- Implementar exportação do relatório financeiro em PDF/CSV.

---

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
