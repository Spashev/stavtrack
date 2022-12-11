<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attribute()
    {
        return $this->belongsTo(VehicleAttribute::class,'id', 'vehicle_id');
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id', 'id');
    }
}
