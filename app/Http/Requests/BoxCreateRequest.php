<?php

namespace App\Http\Requests;

use App\Models\Container;
use Illuminate\Foundation\Http\FormRequest;

class BoxCreateRequest extends FormRequest
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
            'length' => ['required', 'integer', 'min:0'],
            'width' => ['required', 'integer', 'min:0'],
            'height' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'integer', 'min:0']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $box_volume = round(($this->length * $this->width * $this->height) / 1000000, 2);
            
            $container = Container::find($this->container_id);
            
            if($container->free_volume < $box_volume)
            {
                $validator->errors()->add('free_volume', 'There are no free volue to store boxes in this Container');
            }

            $current_weight_capacity = $container->max_load_weight - $container->net_weight;

            if($current_weight_capacity < $this->weight / 1000)
            {
                $validator->errors()->add('net_weight', 'This container can not support the weight of the box');
            }
        });
    }
}
