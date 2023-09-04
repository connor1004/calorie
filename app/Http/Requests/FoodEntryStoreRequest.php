<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodEntryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'taken_at' => 'required|numeric',
            'calorie' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'taken_by' => 'required|exists:users,id',
        ];
    }
}
