<div class="space-y-4">
    <div>
        <x-input-label for="title" value="Título" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
            value="{{ old('title', $book->title ?? '') }}" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="author" value="Autor" />
        <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
            value="{{ old('author', $book->author ?? '') }}" required />
        <x-input-error :messages="$errors->get('author')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="genre" value="Gênero" />
            <x-text-input id="genre" name="genre" type="text" class="mt-1 block w-full"
                value="{{ old('genre', $book->genre ?? '') }}" />
            <x-input-error :messages="$errors->get('genre')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="pages" value="Páginas" />
            <x-text-input id="pages" name="pages" type="number" class="mt-1 block w-full"
                value="{{ old('pages', $book->pages ?? '') }}" />
            <x-input-error :messages="$errors->get('pages')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" onchange="toggleRating(this.value)"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @foreach (['quero_ler' => 'Quero Ler', 'lendo' => 'Lendo', 'lido' => 'Lido'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $book->status ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div id="rating-field">
        <x-input-label for="rating" value="Avaliação (1 a 5)" />
        <x-text-input id="rating" name="rating" type="number" min="1" max="5" class="mt-1 block w-full"
            value="{{ old('rating', $book->rating ?? '') }}" />
        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="notes" value="Anotações" />
        <textarea id="notes" name="notes" rows="4"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $book->notes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>
</div>

<script>
    function toggleRating(status) {
        document.getElementById('rating-field').style.display = status === 'lido' ? 'block' : 'none';
    }
    toggleRating(document.getElementById('status').value);
</script>