---
name: testes
description: Use esta skill ao escrever testes automatizados (Feature ou Unit) para controllers, models ou regras de negócio do projeto.
---

# Padrão de Testes do Projeto

## Estrutura
- Testes de CRUD ficam em `tests/Feature/{Recurso}Test.php`
- Usar `RefreshDatabase` em todo teste que toca o banco

## Cobertura mínima por CRUD
- Usuário autenticado consegue listar (`index`) — status 200
- Usuário autenticado consegue criar (`store`) — assert no banco com `assertDatabaseHas`
- Usuário autenticado consegue editar (`update`)
- Usuário autenticado consegue excluir (`destroy`) — assert com `assertDatabaseMissing`
- Usuário NÃO autenticado é redirecionado ao tentar acessar rotas protegidas

## Convenções
- Usar Factories (`Model::factory()`) para gerar dados de teste, nunca inserir manualmente
- Nomear métodos de teste de forma descritiva: `test_usuario_autenticado_pode_criar_registro()`
- Um `assert` principal por teste sempre que possível (testes focados)

## Comando para rodar
- `php artisan test` ou `php artisan test --filter=NomeDoTeste`