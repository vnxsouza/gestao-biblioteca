<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Livro</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('books.update', $book) }}">
                @csrf
                @method('PUT')
                @include('books._form')

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('books.index') }}"
                        class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>