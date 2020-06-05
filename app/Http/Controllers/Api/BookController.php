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
        $this->validate($request, [
            'isbn' => 'required|numeric|min:30|unique:books',
            'call_number' => 'required|numeric|min:30',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'publisher' => 'required|string|max:150',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'date_published' => 'required',
            'series' => 'required|string|max:15',
            'price' => 'required|numeric',
            'total_copies' => 'required|numeric'
        ]);

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

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $this->validate($request, [
            'call_number' => 'required|numeric|min:30',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'publisher' => 'required|string|max:150',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'date_published' => 'required',
            'series' => 'required|string|max:15',
            'price' => 'required|numeric',
            'total_copies' => 'required|numeric',
            'isbn' => 'required|numeric|min:30|unique:books,isbn,' .$book->id,
        ]);

        $book->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Book successfully updated!',
            'data' => $book
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book successfully deleted!'
        ], Response::HTTP_OK);

    }
}
