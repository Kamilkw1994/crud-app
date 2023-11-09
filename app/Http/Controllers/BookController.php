<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $itemsPerPage = 10;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Get data
        $books = Book::get()->slice($offset, $itemsPerPage);

        // Count number of pages
        $totalItems = count(Book::all());
        $totalPages = ceil($totalItems / $itemsPerPage);

        return view('books.index', compact('books', 'currentPage', 'totalPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::get();
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request): RedirectResponse
    {
        $book = Book::create($request->all());
        $book->authors()->sync($request->input('authors'));

        return redirect()->route('books.index')
                        ->with('success','Książka dodana poprawnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): View
    {
        return view('books.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        $authors = Author::get();
        return view('books.edit',compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book): RedirectResponse
    {
        $book->update($request->all());
        $book->authors()->sync($request->input('authors'));

        return redirect()->route('books.index')
                        ->with('success','Książka zaktualizowana poprawnie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')
                        ->with('success','Książka usunięta poprawnie');
    }
}
