---
name: seguranca
description: Use esta skill ao criar Models, Controllers, Form Requests ou qualquer código que lide com dados do usuário, autenticação ou autorização. Garante práticas seguras contra vulnerabilidades comuns.
---

# Segurança do Projeto

## Mass Assignment
- Toda Model deve declarar `$fillable` explicitamente (nunca usar `$guarded = []`)
- Nunca fazer `Model::create($request->all())` — sempre usar `$request->validated()`

## Autorização
- Toda rota autenticada deve estar dentro do middleware `auth`
- Sempre verificar se o registro pertence ao usuário logado antes de editar/excluir (quando aplicável ao domínio), usando Policy ou verificação direta no controller

## CSRF e formulários
- Todo formulário Blade deve conter `@csrf`
- Ações destrutivas (delete) devem usar método `DELETE` via `@method('DELETE')`, nunca GET

## Validação
- Nunca confiar em validação apenas no front-end — sempre validar no Form Request
- Sanitizar/validar tipos (`string`, `integer`, `email`, etc.) explicitamente em todas as regras

## Dados sensíveis
- Nunca logar senhas ou tokens
- Variáveis sensíveis sempre via `.env`, nunca hardcoded no código
- `.env` nunca deve ser commitado (confirmar que está no `.gitignore`)

## Senhas
- Sempre usar o hashing padrão do Laravel (`Hash::make` / cast `hashed` na Model User)
- Nunca reduzir requisitos de senha do Breeze sem necessidade