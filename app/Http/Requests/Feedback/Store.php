<?php

namespace App\Http\Requests\Feedback;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NoScriptCode;

class Store extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:250',
                new NoScriptCode,
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:250',
            ],
            'title' => [
                'required',
                'string',
                'max:250',
                new NoScriptCode,
            ],
            'text' => [
                'required',
                'string',
                'max:25000',
                new NoScriptCode,
            ],
            'captcha' => 'required|captcha'

        ];
    }
}
