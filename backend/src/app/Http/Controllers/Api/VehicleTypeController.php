<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VehicleTypeDeleteRequest;
use App\Http\Requests\VehicleTypeStoreRequest;
use App\Http\Requests\VehicleTypeUpdateRequest;
use App\Http\Resources\VehicleTypeResource;
use App\Models\VehicleType;

class VehicleTypeController extends BaseController
{
    public function index()
    {
        $types = VehicleType::orderBy('id', 'desc')->paginate(15);

        return VehicleTypeResource::collection($types);
    }

    public function store(VehicleTypeStoreRequest $request)
    {
        $type = VehicleType::create($request->only('name'));

        return $this->sendResponse(VehicleTypeResource::make($type), 'Vehicle type created successfully.');
    }

    public function show(VehicleType $type)
    {
        return $this->sendResponse(VehicleTypeResource::make($type), 'Type retrieved successfully.');
    }

    public function update(VehicleTypeUpdateRequest $request, VehicleType $type)
    {
        try {
            $type->update($request->only('name'));

            return $this->sendResponse(VehicleTypeResource::make($type), 'Vehicle type updated successfully.');
        }  catch (\Throwable $th) {

            return $this->sendError('Vehicle update error.', [
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy(VehicleTypeDeleteRequest $type)
    {
        VehicleType::where('id', $type->id)->delete();

        return $this->sendResponse([], 'Vehicle type deleted successfully.');
    }
}
