<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleStoreRequest extends FormRequest
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
            'model' => 'required|string',
            'vin' => 'required|min:11|max:11',
            'year' => 'required|min:4|max:4',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'user_id' => 'required|exists:users,id',
            'status' => ['required', Rule::in(['active', 'under repair', 'sold', 'not used'])]
        ];
    }
}
