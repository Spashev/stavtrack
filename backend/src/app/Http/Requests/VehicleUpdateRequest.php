<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::guard()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'model' => 'sometimes|string',
            'vin' => 'sometimes|min:11|max:11',
            'year' => 'sometimes|min:4|max:4',
            'type' => 'sometimes|exists:vehicle_types,id',
            'user_id' => 'sometimes|exists:users,id',
            'vehicle_attribute_id' => 'sometimes|exists:vehicle_attributes,id',
            'status' => ['sometimes', Rule::in(['active', 'under repair', 'sold', 'not used'])]
        ];
    }
}
