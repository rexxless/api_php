<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        if (!auth()->user()->is_admin) {
            response()->json(['message' => 'Forbidden for you'], 403)->send();
            exit;
        }
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
        ];
    }
}
