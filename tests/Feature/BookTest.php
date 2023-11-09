<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{
    Book,
    Author,
};

/**
 * @coversDefaultClass \App\Http\Modules\AdminApi\Contacts\Controller
 */
class BookTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->author = Author::factory()->create();
    }

    /**
     * @covers ::create
     */
    public function testCreate()
    {
        $response = $this->post('/books', [
            'title' => 'Test Book',
            'description' => 'Test Book',
            'authors' => [
                0 => $this->author->id,
            ]
        ]);

        $response->assertRedirect('/books');
        $this->assertCount(51, Book::all());
    }

    /**
     * @covers ::edit
     */
    public function testEdit()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'description' => 'Test Book',
            'authors' => [
                0 => $this->author->id,
            ]

        ]);

        $response = $this->put("/books/{$book->id}", [
            'title' => 'Updated Test Book',
            'description' => 'Test Book',
            'authors' => [
                0 => $this->author->id,
            ]
        ]);

        $response->assertRedirect('/books');
        $this->assertEquals('Updated Test Book', $book->fresh()->title);
    }

    /**
     * @covers ::view
     */
    public function testView()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'description' => 'Test Book',
            'authors' => [
                0 => $this->author->id,
            ]
        ]);

        $response = $this->get("/books/{$book->id}");

        $response->assertSee('Test Book');
    }

    /**
     * @covers ::delete
     */
    public function testDelete()
    {
        $book = Book::create([
            'title' => 'Test Book',
            'description' => 'Test Book',
            'authors' => [
                0 => $this->author->id,
            ]
        ]);

        $response = $this->delete("/books/{$book->id}");

        $response->assertRedirect('/books');
        $this->assertCount(50, Book::all());
    }
}
