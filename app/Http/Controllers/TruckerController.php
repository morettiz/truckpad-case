<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArrivalFormRequest;
use App\Model\Arrival;
use Carbon\Carbon;

class TruckerController extends Controller
{
    public function getUnloadedTrucks()
    {
        return response()->json(Arrival::query()->where('is_truck_loaded', false)->paginate());
    }

    public function getTruckOwners()
    {
        return response()->json(Arrival::query()->where('is_vehicle_owner', true)->paginate());
    }

    public function getLoadedTrucks(ArrivalFormRequest $request)
    {
        $date = $request->get('date');
        $date = $date ? Carbon::parse($date)->endOfDay() : Carbon::now()->endOfDay();

        $day   = Arrival::loadedArrivalsBetween($date->copy()->startOfDay(), $date)->get();
        $week  = Arrival::loadedArrivalsBetween($date->copy()->subDays(7)->startOfDay(), $date)->get();
        $month = Arrival::loadedArrivalsBetween($date->copy()->subDays(30)->startOfDay(), $date)->get();

        return response()->json([
            'LOADED_TRUCKS_DURING_DAY' => [
                'total' => $day->count(),
                'drivers' => $day,
            ],
            'LOADED_TRUCKS_DURING_WEEK' => [
                'total' => $week->count(),
                'drivers' => $week,
            ],
            'LOADED_TRUCKS_DURING_MONTH'  => [
                'total' => $month->count(),
                'drivers' => $month,
            ],
        ]);
    }

    public function getRoutesGroupedByTruckType()
    {
        $routesByTruck = Arrival::getRoute()->get()->groupBy('truck.type');

        $routesByTruck = $routesByTruck->map(function ($routes) {
            return [
                'total' => $routes->count(),
                'rotas' => $routes,
            ];
        });

        return response()->json($routesByTruck);
    }
}
