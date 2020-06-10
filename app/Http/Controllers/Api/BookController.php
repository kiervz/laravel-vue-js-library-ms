<?php

namespace App\Http\Controllers\Api;

use App\Book;
use App\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookRequest;
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
        return response()->json([
            "status" => true,
            "messages" => "success",
            "data" => [
                "book_categories" => $book_categories,
                "books" => Book::with('category')->get()
            ]
        ], Response::HTTP_OK);
    }

    public function store(BookRequest $request)
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

    public function update(BookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Book successfully updated!',
            'data' => $book
        ], Response::HTTP_OK);
    }

    public function update_copies(request $request, $id)
    {
        $number_copies = $request->input('number_copies');
        $book = Book::findOrFail($id);

        $request->validate([
            'number_copies' => 'numeric|required',
        ]);

        $book->total_copies += $number_copies;
        $book->avail_copies += $number_copies;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book copies successfully updated!',
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
