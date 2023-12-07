<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:2|max:20',
            'text' => 'required|min:5',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Devi inserire il titolo del project',
            'title.min' => 'Il titolo del project deve avere almeno :min caratteri',
            'title.max' => 'Il titolo del project non può avere più di :max caratteri',
            'text.required' => 'Il testo del project non può essere vuoto',
            'text.min' =>  'Il testo del project deve avere almeno :min caratteri'
        ];
    }


}
