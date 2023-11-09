<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
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
        $authors = Author::get()->slice($offset, $itemsPerPage);

        // Count number of pages
        $totalItems = count(Author::all());
        $totalPages = ceil($totalItems / $itemsPerPage);

        return view('authors.index', compact('authors', 'currentPage', 'totalPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $authors = Author::get();
        return view('authors.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request): RedirectResponse
    {
        $author = Author::create($request->all());

        return redirect()->route('authors.index')
                        ->with('success','Autor dodany poprawnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author): View
    {
        return view('authors.show',compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author): View
    {
        $authors = Author::get();
        return view('authors.edit',compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, Author $author): RedirectResponse
    {
        $author->update($request->all());

        return redirect()->route('authors.index')
                        ->with('success','Autor zaktualizowany poprawnie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();

        return redirect()->route('authors.index')
                        ->with('success','Autor usunięty poprawnie');
    }
}
