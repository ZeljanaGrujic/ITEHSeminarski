<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_name',
        'author_description',
        'author_year_of_birth',
        'author_year_of_death'
    ];
    /**
     * The books that belong to the Author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'authors_books', 'author_id', 'book_id');
    }
}
