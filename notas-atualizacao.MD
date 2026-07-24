# 🚀 Notas de Atualização - Versão 4.0

### 📅 Data da Versão: Julho de 2026
**Projeto:** Futsal da Firma - Sistema de Presença e Gestão Financeira  
**Autor:** Deivid Viquiato Pereira (*VKT CLOUD*)

---

## 📋 Visão Geral da Versão 4.0

A versão **4.0** do projeto traz uma reformulação importante na regra de cálculo do **Saldo do Caixa**, refinamentos na interface do usuário (UI) e a padronização dos créditos e links oficiais da **VKT CLOUD** no rodapé.

---

## ✨ O que mudou nesta versão?

### 💰 1. Nova Lógica Financeira (Cálculo do Saldo do Caixa)
* **Abatimento Dinâmico por Parcelas:** O cálculo do saldo do caixa foi corrigido para considerar as parcelas efetivamente pagas à quadra.
* **Fórmula Aplicada:**
  $$\text{Saldo do Caixa} = \text{Total Arrecadado dos Jogadores} - \text{Total Pago à Quadra (Parcelas)}$$
* **Exibição Dinâmica:** A cor do saldo no card do dashboard muda automaticamente conforme o resultado:
  * 🟢 **Verde (`text-emerald-400`):** Saldo positivo ou zerado.
  * 🔴 **Vermelho (`text-red-400`):** Saldo negativo.

---

### 🌐 2. Atualização do Rodapé e Links Sociais
* **Remoção de Elementos Decorativos:** Removido o ícone de coração animado para manter um visual mais limpo e profissional.
* **Nova Identidade no Rodapé:** Texto de autoria alterado para **`Deivid - VKT CLOUD`**.
* **Integração com Redes Sociais:** Adicionados os ícones com links diretos utilizando *Font Awesome*:
  * 🌐 **Website:** `https://vktcloud.com.br/`
  * 🐙 **GitHub:** `https://github.com/gitvkt`
  * 💼 **LinkedIn:** `https://linkedin.com/in/viquiato`
  * 📷 **Instagram:** `@vktsistemas` (`https://instagram.com/vktsistemas`)

---

### 🎨 3. Ajustes de Layout e Usabilidade
* **Responsividade:** Ajustes na barra do rodapé para se adaptar melhor a telas de smartphones e desktops (`flex-col` para `sm:flex-row`).
* **Estrutura de Tela:** Mantido o alinhamento fixo com `min-h-screen flex flex-col justify-between` para garantir que o rodapé permaneça sempre ao fundo da página.

---

## 🛠️ Resumo de Arquivos Modificados

| Arquivo | Descrição das Modificações |
| :--- | :--- |
| **`index.html`** | Atualização da função `renderizarLista()`, ajuste da tag `<footer>` e adição dos links das redes sociais. |

---

## 📌 Histórico de Versões

* **v4.0 (Atual):** Ajuste na regra de cálculo do saldo, remoção de elementos visuais e inclusão de redes sociais no rodapé.
* **v3.0:** Implementação do parcelamento de pagamento da quadra e arrecadação fixa de R$ 20,00 por jogador.
* **v2.0:** Adição do Painel Administrativo protegido por senha.
* **v1.0:** Lançamento inicial da lista de confirmação de presença e chave Pix.
