<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|string|min:3',
            'description'=>'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'=>'Başlık zorunlu',
            'name.string'=>'Başlık karakterlerden oluşmalı',
            'name.min'=>'Başlık minimum 3 karakterden oluşmalı',
            'description.required'=>'Açıklama zorunlu',
        ];
    }
}
