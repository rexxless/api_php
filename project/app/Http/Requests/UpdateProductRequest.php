<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|text',
            'price' => 'sometimes|integer',
        ];
    }
}
