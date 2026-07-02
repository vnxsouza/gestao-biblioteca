# Biblioteca Pessoal

Sistema web para gerenciamento de biblioteca pessoal, desenvolvido em Laravel.

## Descrição

A aplicação permite que o usuário cadastre e organize os livros que possui, controlando o status de leitura de cada um (Quero Ler / Lendo / Lido), avaliando os livros já lidos e mantendo anotações pessoais. Conta com busca por título/autor, filtro por status e um painel com contagem de livros por status.

## Tecnologias utilizadas

- **Laravel 12** (PHP 8.2+)
- **Laravel Breeze** — autenticação (stack Blade + Tailwind)
- **Laravel Boost** — guidelines, skills e servidor MCP para desenvolvimento assistido por IA
- **SQLite** — banco de dados
- **Tailwind CSS** — estilização
- **PHPUnit** — testes automatizados (Feature tests)

## Requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e npm

## Instalação

1. Clone o repositório e acesse a pasta do projeto:
   ```bash
   git clone <url-do-repositorio>
   cd biblioteca-pessoal
   ```

2. Instale as dependências PHP:
   ```bash
   composer install
   ```

3. Instale as dependências JS e compile os assets:
   ```bash
   npm install
   npm run build
   ```

4. Copie o arquivo de ambiente e gere a chave da aplicação:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure o banco de dados SQLite no `.env`:
   ```
   DB_CONNECTION=sqlite
   ```
   (remova ou comente as demais variáveis `DB_*`)

6. Crie o arquivo do banco:
   ```bash
   touch database/database.sqlite
   ```

7. Rode as migrations e os seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Suba o servidor:
   ```bash
   php artisan serve
   ```

9. Acesse `http://127.0.0.1:8000` no navegador.

## Usuário de teste

| E-mail | Senha | Perfil |
|---|---|---|
| admin@teste.com | password | Usuário padrão (dono do acervo de livros de exemplo) |

## Executando os testes

```bash
php artisan test
```

Ou apenas os testes do CRUD de livros:
```bash
php artisan test --filter=BookTest
```

## Estrutura relevante do projeto

```
├── app/
│   ├── Http/Controllers/BookController.php
│   ├── Http/Requests/StoreBookRequest.php
│   ├── Http/Requests/UpdateBookRequest.php
│   └── Models/Book.php
├── database/
│   ├── factories/BookFactory.php
│   ├── migrations/..._create_books_table.php
│   └── seeders/BookSeeder.php
├── resources/views/books/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── _form.blade.php
├── tests/Feature/BookTest.php
├── .claude/skills/           # Skills de IA (identidade visual, CRUD, segurança, testes)
├── PLANO_IMPLEMENTACAO.md
└── RELATORIO.md
```

## Documentação adicional

- [PLANO_IMPLEMENTACAO.md](./PLANO_IMPLEMENTACAO.md) — plano elaborado antes do desenvolvimento
- [RELATORIO.md](./RELATORIO.md) — relatório completo do processo de desenvolvimento