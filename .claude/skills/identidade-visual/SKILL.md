---
name: identidade-visual
description: Use esta skill sempre que criar ou editar qualquer view Blade, layout, componente ou tela do sistema. Garante consistência visual em toda a aplicação (cores, tipografia, espaçamento, componentes e responsividade).
---

# Identidade Visual do Projeto

## Paleta de cores
- Primária: `#2563EB` (azul) — botões principais, links ativos, destaques
- Secundária: `#64748B` (cinza-azulado) — textos secundários, ícones neutros
- Sucesso: `#16A34A` / Erro: `#DC2626` / Aviso: `#D97706`
- Fundo: `#F8FAFC` / Cards: `#FFFFFF` com `shadow-sm` e `rounded-lg`

## Tipografia
- Fonte padrão do Tailwind (Figtree, já vem no Breeze)
- Títulos de página: `text-2xl font-semibold text-gray-800`
- Subtítulos/seções: `text-lg font-medium text-gray-700`
- Texto padrão: `text-sm text-gray-600`

## Componentes padrão
- Botão primário: `bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium`
- Botão secundário/cancelar: `bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50`
- Botão destrutivo (excluir): `bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md`
- Cards de listagem: `bg-white rounded-lg shadow-sm border border-gray-200 p-4`
- Inputs: `border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full`

## Layout
- Toda página autenticada usa o layout `x-app-layout` do Breeze
- Container central: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
- Espaçamento vertical entre seções: `space-y-6`

## Responsividade
- Mobile-first: sempre testar em `sm:` antes de adicionar breakpoints maiores
- Tabelas de listagem devem colapsar para cards em telas pequenas (`hidden sm:table` + versão mobile alternativa, ou usar `overflow-x-auto`)

## Regras gerais
- Nunca misturar Bootstrap com Tailwind — o projeto usa exclusivamente Tailwind (padrão do Breeze)
- Sempre usar os componentes Blade já existentes em `resources/views/components/` antes de criar novos
- Manter mensagens de feedback (sucesso/erro) com o mesmo padrão visual em todas as telas