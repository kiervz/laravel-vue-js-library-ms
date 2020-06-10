<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isMethodPut = $this->method() == 'PUT';
        return [
            'isbn' => $isMethodPut ? 'required|string|min:9|max:13|unique:books,isbn,' .$this->id: 'required|string|min:9|max:13|unique:books',
            'call_number' => 'required|string|min:7|max:30',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:150',
            'publisher' => 'required|string|max:150',
            'description' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'year_published' => 'required|string|min:4|max:4',
            'series' => 'required|string|min:3|max:15',
            'price' => 'required|numeric',
            'total_copies' => 'required|numeric'
        ];
    }
}
