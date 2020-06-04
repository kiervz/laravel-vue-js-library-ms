<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(Book $book)
    {

    }

    public function edit(Book $book)
    {

    }

    public function update(Request $request, Book $book)
    {

    }

    public function destroy(Book $book)
    {

    }
}
