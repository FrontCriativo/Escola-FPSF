<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'borrowed_at',
        'due_at',
        'returned_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_at' => 'datetime',
            'due_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            'borrowed' => 'Emprestado',
            'returned' => 'Devolvido',
            'overdue' => 'Atrasado',
            'lost' => 'Perdido',
        ];
    }

    public static function activeStatuses(): array
    {
        return ['borrowed', 'overdue', 'lost'];
    }

    protected static function booted(): void
    {
        static::deleting(function (Loan $loan): void {
            if (! $loan->hasActiveStatus()) {
                return;
            }

            $book = Book::query()->lockForUpdate()->find($loan->book_id);

            if ($book !== null) {
                self::releaseCopy($book);
            }
        });
    }

    public static function createManaged(array $attributes): self
    {
        return DB::transaction(function () use ($attributes): self {
            $loan = new self($attributes);
            $loan->status ??= 'borrowed';
            $loan->borrowed_at ??= now();
            $loan->due_at ??= now()->addDays(14);
            $loan->normalizeReturnedAt();

            if ($loan->hasActiveStatus()) {
                $book = Book::query()->lockForUpdate()->findOrFail($loan->book_id);
                self::assertBookCanBeLoaned($book);
                self::reserveCopy($book);
            }

            $loan->save();

            return $loan->refresh();
        });
    }

    public function updateManaged(array $attributes): void
    {
        DB::transaction(function () use ($attributes): void {
            /** @var self $loan */
            $loan = self::query()->lockForUpdate()->findOrFail($this->getKey());
            $originalBookId = $loan->book_id;
            $originalStatus = $loan->status;

            $loan->fill($attributes);
            $loan->normalizeReturnedAt();

            $wasActive = self::statusIsActive($originalStatus);
            $isActive = $loan->hasActiveStatus();
            $bookChanged = (int) $originalBookId !== (int) $loan->book_id;

            if ($wasActive && ($bookChanged || ! $isActive)) {
                $book = Book::query()->lockForUpdate()->findOrFail($originalBookId);
                self::releaseCopy($book);
            }

            if ($isActive && ($bookChanged || ! $wasActive)) {
                $book = Book::query()->lockForUpdate()->findOrFail($loan->book_id);
                self::assertBookCanBeLoaned($book);
                self::reserveCopy($book);
            }

            $loan->save();

            $this->forceFill($loan->getAttributes());
            $this->syncOriginal();
        });
    }

    protected function normalizeReturnedAt(): void
    {
        if ($this->status === 'returned' && $this->returned_at === null) {
            $this->returned_at = now();
        }

        if ($this->status !== 'returned') {
            $this->returned_at = null;
        }
    }

    public function hasActiveStatus(): bool
    {
        return self::statusIsActive($this->status);
    }

    public static function statusIsActive(?string $status): bool
    {
        return in_array($status, self::activeStatuses(), true);
    }

    protected static function assertBookCanBeLoaned(Book $book): void
    {
        if ($book->status !== 'available') {
            throw ValidationException::withMessages([
                'book_id' => 'Este livro nao esta disponivel para emprestimo.',
            ]);
        }

        if ($book->copies_available < 1) {
            throw ValidationException::withMessages([
                'book_id' => 'Nao ha exemplares disponiveis deste livro.',
            ]);
        }
    }

    protected static function reserveCopy(Book $book): void
    {
        $book->update([
            'copies_available' => max(0, $book->copies_available - 1),
        ]);
    }

    protected static function releaseCopy(Book $book): void
    {
        $book->update([
            'copies_available' => min($book->copies_total, $book->copies_available + 1),
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
