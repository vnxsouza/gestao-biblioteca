<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_nao_autenticado_e_redirecionado_ao_acessar_listagem(): void
    {
        $response = $this->get(route('books.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_usuario_autenticado_pode_ver_listagem_de_livros(): void
    {
        $user = User::factory()->create();
        Book::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.index'));

        $response->assertStatus(200);
    }

    public function test_usuario_autenticado_pode_criar_livro(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('books.store'), [
            'title' => 'Dom Casmurro',
            'author' => 'Machado de Assis',
            'status' => 'quero_ler',
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', [
            'title' => 'Dom Casmurro',
            'user_id' => $user->id,
        ]);
    }

    public function test_criar_livro_como_lido_sem_avaliacao_falha_na_validacao(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('books.store'), [
            'title' => 'Livro Teste',
            'author' => 'Autor Teste',
            'status' => 'lido',
        ]);

        $response->assertSessionHasErrors('rating');
    }

    public function test_rating_e_limpo_quando_status_nao_e_lido(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'user_id' => $user->id,
            'status' => 'lido',
            'rating' => 5,
        ]);

        $this->actingAs($user)->put(route('books.update', $book), [
            'title' => $book->title,
            'author' => $book->author,
            'status' => 'lendo',
            'rating' => 5,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => 'lendo',
            'rating' => null,
        ]);
    }

    public function test_usuario_autenticado_pode_atualizar_proprio_livro(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id, 'title' => 'Título Antigo']);

        $response = $this->actingAs($user)->put(route('books.update', $book), [
            'title' => 'Título Novo',
            'author' => $book->author,
            'status' => 'quero_ler',
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Título Novo']);
    }

    public function test_usuario_nao_pode_editar_livro_de_outro_usuario(): void
    {
        $dono = User::factory()->create();
        $outro = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $dono->id]);

        $response = $this->actingAs($outro)->get(route('books.edit', $book));

        $response->assertStatus(403);
    }

    public function test_usuario_autenticado_pode_excluir_proprio_livro(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('books.destroy', $book));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_usuario_nao_pode_excluir_livro_de_outro_usuario(): void
    {
        $dono = User::factory()->create();
        $outro = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $dono->id]);

        $response = $this->actingAs($outro)->delete(route('books.destroy', $book));

        $response->assertStatus(403);
        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}