<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Meus Livros</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <p class="text-sm text-gray-600">Quero Ler</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $counts['quero_ler'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <p class="text-sm text-gray-600">Lendo</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $counts['lendo'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <p class="text-sm text-gray-600">Lido</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $counts['lido'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <form method="GET" action="{{ route('books.index') }}" class="flex flex-col sm:flex-row gap-3 mb-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por título ou autor..."
                    class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">

                <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">Todos os status</option>
                    <option value="quero_ler" @selected(request('status') === 'quero_ler')>Quero Ler</option>
                    <option value="lendo" @selected(request('status') === 'lendo')>Lendo</option>
                    <option value="lido" @selected(request('status') === 'lido')>Lido</option>
                </select>

                <button type="submit" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 text-sm">
                    Filtrar
                </button>
                <a href="{{ route('books.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center">
                    + Novo Livro
                </a>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 pr-4">Título</th>
                            <th class="py-2 pr-4">Autor</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4">Avaliação</th>
                            <th class="py-2 pr-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($books as $book)
                            <tr>
                                <td class="py-2 pr-4 font-medium text-gray-800">{{ $book->title }}</td>
                                <td class="py-2 pr-4 text-gray-600">{{ $book->author }}</td>
                                <td class="py-2 pr-4">
                                    <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                        {{ ['quero_ler' => 'Quero Ler', 'lendo' => 'Lendo', 'lido' => 'Lido'][$book->status] }}
                                    </span>
                                </td>
                                <td class="py-2 pr-4 text-gray-600">{{ $book->rating ? str_repeat('★', $book->rating) : '-' }}</td>
                                <td class="py-2 pr-4 space-x-2">
                                    <a href="{{ route('books.edit', $book) }}" class="text-blue-600 hover:underline">Editar</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este livro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">Nenhum livro encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</x-app-layout>