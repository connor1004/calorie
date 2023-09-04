<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodEntryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'taken_at' => 'numeric',
            'calorie' => 'numeric|min:0',
            'price' => 'numeric|min:0',
            'taken_by' => 'exists:users,id',
        ];
    }
}
