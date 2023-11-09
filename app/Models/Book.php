<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    public const TABLE = 'books';

    public const ID = 'id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const AUTHOR = 'author';

    protected $fillable = [
		self::TITLE,
		self::DESCRIPTION,
		self::AUTHOR,
	];

    public const RELATION_AUTHORS = 'authors';

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'books_has_authors', 'book_id');
    }
}
