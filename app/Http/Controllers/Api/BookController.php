<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $book_categories = BookCategory::all();
        $book = Book::all();

        return response()->json([
            "status" => true,
            "messages" => "success",
            "data" => [
                "book_categories" => $book_categories,
                "book" => $book
            ]
        ], Response::HTTP_OK);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $status = "error";
        $message = "Book failed to create.";
        $code = Response::HTTP_CONFLICT;
        $data = $request->all();

        $request['avail_copies'] = $request->total_copies;
        $book = Book::create($request->all());

        if ($book) {
            $status = "success";
            $message = "Book successfully created!";
            $code = Response::HTTP_CREATED;
            $data = $book;
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $book
        ], $code);
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
