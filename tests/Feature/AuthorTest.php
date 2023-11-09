<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{
    Author,
};

/**
 * @coversDefaultClass \App\Controller
 */
class AuthorTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @covers ::create
     */
    public function testCreate()
    {
        $response = $this->post('/authors', [
            'first_name' => 'Andrzej',
            'last_name' => 'Sapkowski',
        ]);

        $response->assertRedirect('/authors');
        $this->assertCount(26, Author::all());
    }

    /**
     * @covers ::edit
     */
    public function testEdit()
    {
        $author = Author::create([
            'first_name' => 'Andrzej',
            'last_name' => 'Sapkowski',

        ]);

        $response = $this->put("/authors/{$author->id}", [
            'first_name' => 'Henryk',
            'last_name' => 'Sapkowski',
        ]);

        $response->assertRedirect('/authors');
        $this->assertEquals('Henryk', $author->fresh()->first_name);
    }

    /**
     * @covers ::View
     */
    public function testView()
    {
        $author = Author::create([
            'first_name' => 'Andrzej',
            'last_name' => 'Sapkowski',
        ]);

        $response = $this->get("/authors/{$author->id}");

        $response->assertSee('Andrzej');
    }

    /**
     * @covers ::delete
     */
    public function testDelete()
    {
        $author = Author::create([
            'first_name' => 'Andrzej',
            'last_name' => 'Sapkowski',
        ]);

        $response = $this->delete("/authors/{$author->id}");

        $response->assertRedirect('/authors');
        $this->assertCount(25, Author::all());
    }
}
