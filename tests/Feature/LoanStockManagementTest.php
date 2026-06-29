<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoanStockManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_an_active_loan_reserves_one_copy(): void
    {
        $loan = Loan::createManaged([
            'user_id' => User::factory()->create()->id,
            'book_id' => $this->makeBook(copiesAvailable: 2)->id,
            'status' => 'borrowed',
        ]);

        $this->assertSame('borrowed', $loan->status);
        $this->assertDatabaseHas('books', [
            'id' => $loan->book_id,
            'copies_available' => 1,
        ]);
    }

    public function test_returning_a_book_restores_the_available_copy(): void
    {
        $book = $this->makeBook(copiesAvailable: 1);
        $loan = Loan::createManaged([
            'user_id' => User::factory()->create()->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        $loan->updateManaged(['status' => 'returned']);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'copies_available' => 1,
        ]);
        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'status' => 'returned',
        ]);
    }

    public function test_cannot_create_active_loan_when_book_has_no_available_copies(): void
    {
        $this->expectException(ValidationException::class);

        Loan::createManaged([
            'user_id' => User::factory()->create()->id,
            'book_id' => $this->makeBook(copiesAvailable: 0, status: 'reserved')->id,
            'status' => 'borrowed',
        ]);
    }

    public function test_marking_a_loan_as_lost_keeps_the_copy_unavailable(): void
    {
        $book = $this->makeBook(copiesAvailable: 1);
        $loan = Loan::createManaged([
            'user_id' => User::factory()->create()->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        $loan->updateManaged(['status' => 'lost']);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'copies_available' => 0,
        ]);
        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'status' => 'lost',
        ]);
    }

    private function makeBook(int $copiesAvailable, string $status = 'available'): Book
    {
        $category = Category::query()->create([
            'name' => 'Literatura',
            'slug' => 'literatura',
            'color' => '#a8c7a0',
        ]);

        return Book::query()->create([
            'category_id' => $category->id,
            'title' => 'Livro de teste '.fake()->unique()->word(),
            'author' => 'Autor',
            'status' => $status,
            'copies_total' => max(1, $copiesAvailable),
            'copies_available' => $copiesAvailable,
            'is_featured' => false,
        ]);
    }
}
