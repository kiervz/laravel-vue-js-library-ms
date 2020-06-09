<?php

namespace App\Http\Controllers\Api;

use App\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class BookCategoryController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'string|required|unique:book_categories|max:50',
        ]);

        $status = "error";
        $message = "Category failed to create.";
        $code = Response::HTTP_CONFLICT;
        $data = $request->all();

        $book_category = BookCategory::create($request->all());

        if ($book_category) {
            $status = 'success';
            $message = 'Category successfully added!';
            $code = Response::HTTP_CREATED;
            $data = $book_category;
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $book_category
        ], $code);
    }

    public function show($id)
    {
        $category = BookCategory::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $category,
        ], Response::HTTP_OK);
    }

    public function edit(BookCategory $bookCategory)
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'string|required|unique:book_categories|max:50',
        ]);

        $status = "error";
        $message = "Category failed to update.";
        $code = Response::HTTP_CONFLICT;

        $book_category = BookCategory::findOrFail($id);
        $book_category->category = $request->category;
        $book_category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category successfully updated!',
            'data' => $book_category
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {

    }
}
