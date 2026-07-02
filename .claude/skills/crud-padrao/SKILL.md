---
name: crud-padrao
description: Use esta skill sempre que criar ou modificar um CRUD (Controller, Model, rotas, views de index/create/edit/show). Garante que todos os CRUDs do projeto sigam a mesma estrutura e convenções.
---

# Padrão de CRUD do Projeto

## Estrutura de Controller
- Sempre usar Controllers do tipo `resource` (`php artisan make:controller NomeController --resource`)
- Métodos seguem exatamente: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`
- Lógica de validação NUNCA fica no controller — sempre em Form Request dedicado

## Form Requests
- Um Form Request por ação de escrita: `StoreXRequest` e `UpdateXRequest`
- `authorize()` sempre retorna `true` a menos que haja regra de permissão explícita
- Mensagens de erro em português, usando `messages()` no Form Request

## Rotas
- Sempre usar `Route::resource('recurso', Controller::class)` dentro de um grupo `middleware(['auth'])`
- Nomes de rota no padrão automático do `resource` (não customizar nomes sem necessidade)

## Views
- Cada CRUD tem sua pasta em `resources/views/{recurso}/` com: `index.blade.php`, `create.blade.php`, `edit.blade.php`
- `create` e `edit` compartilham um partial `_form.blade.php` para evitar duplicação
- `index` sempre com paginação: `->paginate(10)` no controller, `{{ $items->links() }}` na view

## Paginação e listagem
- Padrão de 10 itens por página
- Sempre incluir busca simples por texto quando fizer sentido para a entidade

## Mensagens de feedback
- Após `store`: `session('success', 'Registro criado com sucesso.')`
- Após `update`: `session('success', 'Registro atualizado com sucesso.')`
- Após `destroy`: `session('success', 'Registro removido com sucesso.')`
- Exibir essas mensagens usando o mesmo componente de alerta em todas as telas

## Boas práticas
- Sempre usar Route Model Binding (`function show(Model $model)`) em vez de buscar por ID manualmente
- Confirmar exclusão no front-end antes de disparar `destroy` (modal ou `confirm()`)
- Nunca usar `Model::all()` sem paginação em listagens