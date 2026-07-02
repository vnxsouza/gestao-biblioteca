<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = auth()->user()->books()
            ->status($request->get('status'))
            ->search($request->get('q'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'quero_ler' => auth()->user()->books()->where('status', 'quero_ler')->count(),
            'lendo' => auth()->user()->books()->where('status', 'lendo')->count(),
            'lido' => auth()->user()->books()->where('status', 'lido')->count(),
        ];

        return view('books.index', compact('books', 'counts'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(StoreBookRequest $request)
    {
        auth()->user()->books()->create($request->validated());

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso.');
    }

    public function edit(Book $book)
    {
        abort_if($book->user_id !== auth()->id(), 403);

        return view('books.edit', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
    }

    public function destroy(Book $book)
    {
        abort_if($book->user_id !== auth()->id(), 403);

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro removido com sucesso.');
    }
}