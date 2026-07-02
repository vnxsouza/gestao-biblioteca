# Relatório — Biblioteca Pessoal

## 1. Contexto e Planejamento

### Tema
Sistema de gerenciamento de biblioteca pessoal, permitindo ao usuário cadastrar livros, controlar o status de leitura (Quero Ler / Lendo / Lido), avaliar os livros lidos e manter anotações pessoais.

### Descrição da aplicação
A aplicação resolve o problema de leitores que perdem o controle sobre seu acervo — quais livros possuem, quais já leram, quais avaliações deram — ao centralizar essas informações em um sistema único, com autenticação por usuário, busca e filtros.

### Plano de Implementação
O Plano de Implementação foi elaborado **antes** da geração de qualquer código com IA e está disponível em [`PLANO_IMPLEMENTACAO.md`](./PLANO_IMPLEMENTACAO.md), contendo objetivo, escopo, entidades do banco de dados, telas, ordem de implementação, tecnologias, riscos e critérios de aceite.

---

## 2. Ferramentas de IA

### MCP utilizado
Foi utilizado o **MCP Server do Laravel Boost** (`laravel-boost`), configurado durante a instalação do pacote (`php artisan boost:install`) e integrado ao agente de desenvolvimento (Claude Code).

**Finalidade:** o MCP do Laravel Boost expõe ao agente de IA ferramentas para inspecionar a estrutura real da aplicação — rotas registradas, schema do banco de dados, execução de comandos Artisan e consulta a uma base de documentação do ecossistema Laravel — em vez de a IA depender apenas de conhecimento genérico ou "adivinhar" convenções do projeto.

**Exemplos de utilização durante o desenvolvimento:**
- Consulta das rotas registradas (`route:list`) via MCP para confirmar que o `Route::resource('books', ...)` havia sido corretamente registrado dentro do grupo de middleware `auth`, antes de prosseguir para a criação das views.
- Consulta ao schema do banco de dados via MCP para validar que a migration de `books` (com o relacionamento `belongsTo User`) estava consistente com o Plano de Implementação antes de gerar o Model e o Controller.
- Uso da base de documentação do Laravel (via Boost) para garantir que os Form Requests (`StoreBookRequest`, `UpdateBookRequest`) seguissem a convenção atual do framework, incluindo a regra condicional `required_if` para o campo de avaliação.

### Skills desenvolvidas
Todas as skills foram armazenadas em `.claude/skills/`, conforme estrutura definida pelo Laravel Boost para o agente utilizado (Claude Code):

- **`identidade-visual`** (obrigatória): define paleta de cores, tipografia, componentes Blade padronizados (botões, cards, inputs) e regras de responsividade, garantindo consistência visual entre as telas de login, dashboard e CRUD de livros.
- **`crud-padrao`** (obrigatória): define a estrutura padrão de Controllers (resource), Form Requests, paginação, mensagens de feedback e uso de Route Model Binding, aplicada ao CRUD de `Book`.
- **`seguranca`** (opcional): orienta sobre mass assignment (`$fillable`), autorização por dono do registro, uso de CSRF e validação server-side — aplicada diretamente na correção que impede um usuário de editar/excluir livros de outro usuário (retorno HTTP 403).
- **`testes`** (opcional): define o padrão de testes Feature (uso de `RefreshDatabase`, Factories, nomenclatura descritiva), seguido na criação do `BookTest.php`.

---

## 3. Desenvolvimento

### Funcionalidades implementadas
- Autenticação (registro, login, logout) via Laravel Breeze
- CRUD completo de livros (criar, listar, editar, excluir)
- Classificação por status de leitura (Quero Ler / Lendo / Lido)
- Avaliação (1 a 5) restrita a livros com status "Lido"
- Busca por título/autor e filtro por status na listagem
- Painel com contagem de livros por status
- Controle de acesso: um usuário não pode editar/excluir livros de outro usuário
- Testes automatizados cobrindo o CRUD completo e as regras de autorização/validação

### Decisões de projeto
- **SQLite** foi escolhido no lugar de MySQL/PostgreSQL para simplificar a configuração do ambiente de desenvolvimento, sem exigir instalação de um servidor de banco separado.
- O CRUD foi implementado como um único recurso (`Route::resource`) para manter a aderência às convenções padrão do Laravel, conforme orientado pela skill `crud-padrao`.
- O campo `rating` foi tratado tanto na validação (front-end via JavaScript simples e back-end via `required_if`) quanto na lógica do Controller, para impedir inconsistência de dados mesmo em cenários não previstos pela interface.

### Dificuldades encontradas
- Durante a primeira execução de `php artisan migrate`, o retorno "Nothing to migrate" gerou dúvida sobre se as tabelas haviam sido realmente criadas; foi resolvido verificando o status das migrations com `php artisan migrate:status`.
- A posição correta para registrar as rotas do recurso `books` no `routes/web.php` exigiu atenção, já que o projeto já possuía um grupo de rotas `middleware('auth')` criado pelo Breeze — a rota foi adicionada dentro desse grupo existente, evitando duplicação.
- Foi identificada, durante os testes manuais, uma inconsistência: ao alterar o status de um livro de "Lido" para outro status, o valor de `rating` permanecia salvo no banco mesmo com o campo oculto na interface. A correção foi aplicada diretamente no Controller, limpando o `rating` sempre que o status não é "lido", reforçando a prática (definida na skill de segurança) de não confiar apenas em validações do lado do cliente.

---

## 4. Conclusão

### Limitações da aplicação
- Não há integração com bases de dados externas de livros (ex: Google Books), portanto o cadastro é inteiramente manual.
- O sistema não oferece compartilhamento de acervo entre usuários nem recomendação de livros.
- A capa do livro não é suportada (apenas dados textuais).

### Utilização da IA durante o desenvolvimento
A IA (via Claude Code, com Laravel Boost fornecendo contexto real do projeto através do MCP e das skills) foi utilizada para gerar a primeira versão de migrations, models, controllers, form requests, rotas, views e testes, a partir do Plano de Implementação previamente definido. Todo o código gerado foi revisado manualmente: rotas foram verificadas com `route:list`, o fluxo de CRUD foi testado manualmente na interface (criação, edição, exclusão, filtros, mensagens de erro), e uma inconsistência real de dados (`rating` não sendo limpo ao mudar o status) foi identificada durante os testes e corrigida antes da entrega. As skills desenvolvidas garantiram consistência visual e estrutural entre as telas, evitando que a IA gerasse padrões divergentes a cada solicitação.

### Conclusão geral
O projeto atingiu os requisitos mínimos propostos: autenticação funcional, banco de dados com migrations e seeders, um CRUD completo com layout consistente, uso documentado de MCP e Plano de Implementação elaborado previamente à geração de código. A combinação de Laravel Boost (contexto real da aplicação para a IA) com Skills bem definidas (convenções fixas de código e visual) mostrou-se eficaz para manter qualidade e consistência ao longo do desenvolvimento assistido por IA, desde que acompanhada de revisão e testes manuais por parte do desenvolvedor.