⚽ Futsal da Firma — Sistema de Gestão de Lista e Caixa de Jogos
📄 Conceito do Projeto
1. 📌 O que é? (O Conceito)
O Futsal da Firma é uma aplicação web leve, responsiva e dinâmica desenvolvida para automatizar a organização de partidas recreativas de futebol de salão (futsal). O sistema combina a confirmação de presença dos jogadores em tempo real com um painel financeiro transparente, permitindo o acompanhamento do custo da quadra, arrecadações e saldo do caixa.

2. 🎯 Para quê? (Objetivos)
Transparência Financeira: Exibir claramente a arrecadação total, quanto já foi pago pelo aluguel da quadra e qual o saldo restante do caixa da rodada.

Facilidade de Pagamento: Agilizar o recebimento das contribuições integrando a chave PIX e botão de cópia direta na interface, além de link direto para envio de comprovantes via WhatsApp.

Praticidade de Acesso: Permitir que os jogadores visualizem a lista de presença sem a necessidade de criar contas ou efetuar login, mantendo o controle administrativo restrito e protegido por autenticação simples.

3. 💡 Por quê? (A Motivação)
A organização de jogos de futebol amadores frequentemente enfrenta desafios recorrentes:

Falta de controle de pagamentos: Dificuldade em saber quem já pagou e quem está pendente.

Falta de clareza no caixa: A arrecadação em grupos de mensagens (como WhatsApp) se perde facilmente em meio às conversas.

Inadimplência não intencional: Jogadores esquecem de enviar o PIX por falta de um canal centralizado e acessível.

O projeto foi idealizado para resolver essas dores com uma solução centralizada, acessível por qualquer dispositivo móvel, eliminando a dependência de planilhas manuais ou anotações informais.

4. 👥 Para quem serve? (Público-Alvo)
Organizadores de Futsal/Futebol Amador: Pessoas que assumem a responsabilidade de alugar a quadra e recolher o dinheiro dos participantes.

Jogadores/Participantes: Integrantes dos jogos que buscam praticidade para confirmar presença, copiar a chave PIX e verificar a situação financeira da rodada.

Comunidades e Grupos de Esporte Recreativo: Qualquer grupo esportivo que necessite de controle financeiro e de lista de presença simplificado.

5. 🛠️ Como foi idealizado e construído? (Arquitetura e Tecnologia)
Idealização:
O projeto foi pensado sob a premissa de ser ágil, elegante e funcional em dispositivos móveis (Mobile-First). A interface foi estruturada em um modelo de página única (Single Page Application - SPA), permitindo consumo rápido de dados via requisições assíncronas em segundo plano, sem necessidade de recarregar a tela.

Arquitetura Tecnológica:
Front-end:

HTML5 Semantic: Estruturação acessível e otimizada.

Tailwind CSS (via CDN): Estilização moderna e utilitária com suporte nativo a temas escuros (Dark Mode).

JavaScript (Vanilla ES6+): Manipulação dinâmica do DOM, consumo de API assíncrona (fetch) e lógica de renderização sem dependência de frameworks pesados.

FontAwesome: Iconografia intuitiva e visual.

Back-end:

PHP 8.x: API RESTful enxuta responsável por processar as requisições HTTP (GET, POST, DELETE) e retornar os dados estritamente em formato JSON.

PDO (PHP Data Objects): Camada de abstração de dados que garante segurança contra ataques de SQL Injection.

Banco de Dados:

MySQL / MariaDB: Modelagem relacional composta por tabelas para cadastro de jogadores, histórico de pagamentos da quadra e configurações de parâmetros globais.


🎓 Aplicação para Projeto Extensionista

Este projeto foi desenvolvido como uma solução de Inovação e Tecnologia Aplicada à Comunidade local, demonstrando como a transformação digital de processos informais (como a gestão de grupos esportivos) promove a transparência, organização comunitária e inclusão digital. A aplicação de tecnologias web de código aberto possibilita a replicação gratuita do sistema para associações de bairro, centros comunitários e pequenos grupos esportivos da região.
