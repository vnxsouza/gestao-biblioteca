# Plano de Implementação — Biblioteca Pessoal

## 1. Contexto

### 1.1 Objetivo da aplicação
Desenvolver um sistema web para gerenciamento de biblioteca pessoal, permitindo ao usuário cadastrar, organizar e acompanhar os livros que possui, já leu, está lendo ou pretende ler.

### 1.2 Problema que resolve
Leitores costumam perder o controle de quais livros já possuem, quais já leram, avaliações que deram e o que pretendem ler em seguida — geralmente espalhado em planilhas, anotações soltas ou na memória. O sistema centraliza essas informações em um único lugar, com busca e filtros simples.

### 1.3 Público-alvo
Pessoas que leem com frequência e querem organizar seu acervo pessoal e histórico de leitura, sem depender de redes sociais de leitura externas.

---

## 2. Escopo

### 2.1 Funcionalidades
- Autenticação de usuário (login/registro) — via Laravel Breeze
- CRUD completo de **Livros** (cadastrar, listar, editar, excluir, visualizar detalhes)
- Classificação de cada livro por **status de leitura**: Quero Ler / Lendo / Lido
- Avaliação do livro (nota de 1 a 5) quando marcado como "Lido"
- Filtro de listagem por status
- Busca por título/autor na listagem
- Dashboard simples com contagem de livros por status

### 2.2 Fora do escopo (não será implementado)
- Integração com APIs externas de livros (Google Books, etc.)
- Empréstimo de livros entre usuários
- Sistema de recomendação
- Múltiplos usuários compartilhando o mesmo acervo

### 2.3 Entidades do banco de dados

**users** (já provida pelo Laravel/Breeze)
- id, name, email, password, timestamps

**books**
| Campo | Tipo | Observação |
|---|---|---|
| id | bigint | PK |
| user_id | foreignId | FK para `users`, dono do registro |
| title | string | obrigatório |
| author | string | obrigatório |
| genre | string | opcional |
| status | enum('quero_ler','lendo','lido') | default `quero_ler` |
| rating | tinyInteger, nullable | 1 a 5, preenchido apenas se `status = lido` |
| notes | text, nullable | anotações pessoais sobre o livro |
| pages | integer, nullable | número de páginas |
| created_at / updated_at | timestamps | |

> Relacionamento: `User hasMany Books` / `Book belongsTo User`

### 2.4 Telas
1. **Login / Registro** — geradas pelo Breeze
2. **Dashboard** — resumo com contagem por status (cards)
3. **Listagem de Livros** (`index`) — tabela/cards com busca e filtro por status, paginação
4. **Cadastro de Livro** (`create`)
5. **Edição de Livro** (`edit`)
6. **Detalhes do Livro** (`show`) — opcional, pode reaproveitar o modal de edição
7. **Confirmação de exclusão** — modal ou tela simples

---

## 3. Ordem de implementação

1. Configuração do projeto Laravel + banco SQLite
2. Autenticação (Laravel Breeze)
3. Instalação e configuração do Laravel Boost + MCP
4. Criação das Skills (Identidade Visual, CRUD, Segurança, Testes)
5. Migration + Model + Factory + Seeder de `books`
6. Controller `BookController` (resource) + Form Requests
7. Rotas protegidas por `auth`
8. Views: index (listagem + filtro + busca), create, edit
9. Dashboard com contagem por status
10. Ajustes visuais conforme a Skill de Identidade Visual
11. Testes automatizados do CRUD (bônus)
12. Revisão final, README e RELATORIO.md

---

## 4. Aspectos técnicos

### 4.1 Tecnologias utilizadas
- Laravel 12 (PHP 8.2+)
- Laravel Breeze (autenticação, stack Blade + Tailwind)
- Laravel Boost (guidelines, skills, MCP server)
- SQLite (banco de dados, simplicidade para ambiente de desenvolvimento/entrega)
- Tailwind CSS (estilização, padrão do Breeze)
- Pest ou PHPUnit (testes, se implementado o bônus)

### 4.2 Riscos
| Risco | Mitigação |
|---|---|
| Prazo apertado | Escopo reduzido a um único CRUD principal, sem integrações externas |
| Código gerado por IA com erros sutis | Revisão manual de todo código antes de commitar, testes básicos |
| Inconsistência visual entre telas | Uso obrigatório da Skill de Identidade Visual em toda geração de view |
| Falta de commits distribuídos | Commits planejados por etapa (ver seção "Ordem de implementação") |

### 4.3 Critérios de aceite
- [ ] Usuário consegue se registrar e fazer login
- [ ] Usuário autenticado consegue criar, listar, editar e excluir um livro
- [ ] Listagem permite filtrar por status e buscar por título/autor
- [ ] Avaliação (rating) só é exibida/editável quando status = "Lido"
- [ ] Dashboard exibe contagem correta de livros por status
- [ ] Todas as telas seguem a paleta e componentes definidos na Skill de Identidade Visual
- [ ] Banco populado via seeder com usuário(s) de teste e livros de exemplo
- [ ] README e RELATORIO.md completos e coerentes com o que foi implementado