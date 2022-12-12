<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'vin' => $this->vin,
            'year' => $this->year,
            'type' => $this->type->name,
            'user' => $this->user->name,
            'status' => $this->status,
            'attribute' => json_decode($this->attribute ? $this->attribute->body : ''),
        ];
    }
}
