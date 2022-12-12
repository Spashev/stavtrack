<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VehicleDeleteRequest;
use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Models\VehicleAttribute;

class VehicleController extends BaseController
{
    public function index()
    {
        $vehicles = Vehicle::with('attribute', 'type', 'user')->orderBy('id', 'desc')->paginate(15);

        return VehicleResource::collection($vehicles);
    }

    public function store(VehicleStoreRequest $request)
    {
        try {
            $userId = $request->user()->id;
            $vehicle = Vehicle::create($request->only('model', 'vin', 'year', 'status') + [
                'user_id' => $userId,
                'vehicle_type_id' => $request->type
            ]);

            VehicleAttribute::create([
                'body' => json_encode($request->attribute),
                'vehicle_id' => $vehicle->id
            ]);

            return $this->sendResponse(VehicleResource::make($vehicle), 'Vehicle created successfully.');
        } catch (\Throwable $th) {

            return $this->sendError('Vehicle creation error.', [
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(Vehicle $vehicle)
    {
        return $this->sendResponse(VehicleResource::make($vehicle), 'Vehicle retrieved successfully.');
    }

    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        try {
            $vehicle->update($request->only('model', 'vin', 'year', 'status') + ['vehicle_type_id' => $request->type]);

            VehicleAttribute::where('vehicle_id', $vehicle->id)->delete();
            VehicleAttribute::create([
                'body' => json_encode($request->attribute),
                'vehicle_id' => $vehicle->id
            ]);

            return $this->sendResponse(VehicleResource::make($vehicle), 'Vehicle updated successfully.');
        }  catch (\Throwable $th) {

            return $this->sendError('Vehicle update error.', [
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return $this->sendResponse([], 'Vehicle deleted successfully.');
    }
}
