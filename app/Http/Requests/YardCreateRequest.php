<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class YardCreateRequest extends FormRequest
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
        $min_width = config('constants.container.width');
        $min_length = config('constants.container.length');
        
        return [
            'locator' => ['required', 'size:3', 'regex:/[A-Z]{3}/', 'unique:App\Models\Yard,locator'],
            'width' => ['integer','required', "min:$min_width"],
            'length' => ['integer', 'required', "min:$min_length"]
        ];
    }
}
